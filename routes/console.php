<?php

use App\Console\Commands\UpdateArticleCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command(UpdateArticleCommand::class, function () {
    Log::info("Started scheduled task");
})->everyMinute()->withoutOverlapping();
