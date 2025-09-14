<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump {--database= : The database connection to use} {--path= : The path where the dump file should be stored}'; 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump the database to a SQL file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = $this->option('database') ?: config('database.default');
        $config = config("database.connections.{$connection}");

        if ($config['driver'] !== 'mysql') {
            $this->error("This command only supports MySQL/MariaDB databases.");
            return 1;
        }

        $host = $config['host'];
        $port = $config['port'];
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];

        $path = $this->option('path') ?: database_path("dumps/{$database}_" . date('Y-m-d_His') . '.sql');
        
        // Ensure the directory exists
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $command = sprintf(
            'mysqldump -h %s -P %s -u %s -p%s %s > %s',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        $this->info("Dumping database {$database} to {$path}");
        
        $result = 0;
        system($command, $result);

        if ($result === 0) {
            $this->info("Database dump completed successfully.");
            $this->info("Dump file: {$path}");
            return 0;
        } else {
            $this->error("Database dump failed.");
            return 1;
        }
    }
}