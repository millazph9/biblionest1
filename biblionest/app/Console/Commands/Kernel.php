<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Définir la planification des tâches artisan.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:generer-penalites')->dailyAt('01:00');
    }


    /**
     * Enregistrer les commandes Artisan.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        // Optionnel : inclure les routes de console si tu en utilises
        require base_path('routes/console.php');
    }
}
