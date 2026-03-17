<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrowing;
use App\Models\Penalty;
use Carbon\Carbon;

class GenererPenalites extends Command
{
    protected $signature = 'app:generer-penalites';
    protected $description = 'Génère des pénalités pour les emprunts en retard';

    public function handle()
    {
        $tarifJournalier = 1.00;

        $empruntsEnRetard = Borrowing::whereNull('returned_at') // pas encore rendu
            ->where('due_date', '<', now()) // date dépassée
            ->get();

        $count = 0;

        foreach ($empruntsEnRetard as $emprunt) {
            $penaliteExistante = Penalty::where('borrowing_id', $emprunt->id)->exists();

            if (!$penaliteExistante) {
                $joursDeRetard = now()->diffInDays(Carbon::parse($emprunt->due_date));

                Penalty::create([
                    'borrowing_id' => $emprunt->id,
                    'amount' => $joursDeRetard * $tarifJournalier,
                    'paid' => false,
                    'auto_generated' => true,
                ]);

                $count++;
            }
        }

        $this->info("✅ $count pénalité(s) générée(s).");
    }
}
