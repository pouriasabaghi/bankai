<?php

namespace App\Console;

use App\Models\Installment;
use App\Notifications\InstallmentNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function(){
            // delete all installments notification
            DatabaseNotification::query()->where('notifiable_type', Installment::class)->delete();
            $debtorInstallments =Installment::query()->where('due_at', '<=', now())->where('status', 'billed')->with('contract')->get();
            $debtorInstallments->each(function($installment, $key){
               Notification::send($installment,  new InstallmentNotification($installment));
            });
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
