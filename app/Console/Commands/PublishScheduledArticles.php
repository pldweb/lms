<?php

namespace App\Console\Commands;

use App\Models\Artikel;
use Illuminate\Console\Command;
use Carbon\Carbon;

class PublishScheduledArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artikel:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled articles that are due';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        
        // Find scheduled articles that should be published
        $scheduledArticles = Artikel::where('status', 'scheduled')
            ->where('tanggal_publish', '<=', $now)
            ->get();

        if ($scheduledArticles->isEmpty()) {
            $this->info('No scheduled articles to publish.');
            return 0;
        }

        $count = 0;
        foreach ($scheduledArticles as $artikel) {
            try {
                $artikel->update(['status' => 'publish']);
                $count++;
                $this->line("Published: {$artikel->judul}");
            } catch (\Exception $e) {
                $this->error("Failed to publish: {$artikel->judul} - {$e->getMessage()}");
            }
        }

        $this->info("Successfully published {$count} scheduled articles.");
        return 0;
    }
}
