<?php

namespace App\Console\Commands;

use App\Services\NewsAPI;
use App\Services\NewYorkTimes;
use App\Services\TheGuardian;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateArticleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:article';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update article from the various article source';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sources  = [
            new NewsAPI(),
            new NewYorkTimes(),
            new TheGuardian()
        ];
        foreach ($sources as $source) {
            Log::info("Fetching from source: " . $source::NAME);
            $source->fetch();
        }
    }
}
