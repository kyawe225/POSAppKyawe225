<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\PromoCupon;

class CuponActiveJob implements ShouldQueue
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
        $promoCupons = PromoCupon::where("status", "=", "scheduled")->get();
        foreach ($promoCupons as $p) {
            if($p->valid_from->startOfDay() > Carbon::now("utc")->startOfDay()){
                $p["status"]='active';
                $p->save();
            }
        }
    }
}
