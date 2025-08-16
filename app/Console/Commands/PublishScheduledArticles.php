<?php

namespace App\Console\Commands;

use App\Models\Artikel;
use Illuminate\Console\Command;
use Carbon\Carbon;

class PublishScheduledArticles extends Command
{
    protected $signature = 'artikel:publish-scheduled';

    protected $description = 'Publish scheduled articles that are due';

    public function handle()
    {
        $now = Carbon::now();
        
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
