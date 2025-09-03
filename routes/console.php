<?php

use App\Jobs\CuponActiveJob;
use App\Jobs\CuponExpiredJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(CuponActiveJob::class)->daily();
Schedule::call(CuponExpiredJob::class)->daily();