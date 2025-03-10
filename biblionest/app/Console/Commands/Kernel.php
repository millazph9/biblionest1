<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Enregistrer les commandes Artisan
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }

    /**
     * Définir la planification des tâches artisan
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('penalties:check')->everyMinute()->withoutOverlapping();
    }
    
}
