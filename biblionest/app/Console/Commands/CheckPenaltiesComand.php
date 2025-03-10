<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Penalty;
use App\Models\Borrowing;
use Illuminate\Console\Command;



class CheckPenaltiesComand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'penalties:check';
    protected $description = 'Vérifie les emprunts en retard et applique des pénalités si nécessaire.';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
    
        // Récupérer les emprunts en retard
        $borrowings = Borrowing::whereNull('returned_at')
            ->where('due_date', '<', $today)
            ->get();
    
        if ($borrowings->isEmpty()) {
            $this->info("⚠️ Aucun emprunt en retard détecté !");
            return;
        }
    
        foreach ($borrowings as $borrowing) {
            $this->info("📌 Emprunt trouvé : Livre '{$borrowing->book->title}' - Retardé depuis {$borrowing->due_date}");
    
            // Vérifier si une pénalité existe déjà pour cet emprunt
            $penaltyExists = Penalty::where('borrowing_id', $borrowing->id)->exists();
    
            if (!$penaltyExists) {
                // Créer une nouvelle pénalité pour l'emprunt en retard
                $penalty = Penalty::create([
                    'borrowing_id' => $borrowing->id,
                    'amount' => 5, // Montant fixe ou à calculer dynamiquement
                    'paid' => false,
                ]);
    
                $this->info("✅ Pénalité enregistrée pour l'emprunt #{$borrowing->id} - Livre : {$borrowing->book->title}");
            } else {
                $this->info("⚠️ Une pénalité existe déjà pour cet emprunt.");
            }
        }
    
        $this->info("🔍 Vérification des pénalités terminée.");
    }
}    