<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\PromoCupon;

class CuponExpiredJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $promoCupons = PromoCupon::where("status", "=", "active")->get();
        foreach ($promoCupons as $p) {
            if($p->valid_until->startOfDay() <= Carbon::now("utc")->startOfDay()){
                $p["status"]='expired';
                $p->save();
            }
        }
    }
}
