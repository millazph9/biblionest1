<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class BorrowingSeeder extends Seeder
{
    public function run()
    {
        // Récupérer un utilisateur et un livre existants
        $user = User::first(); // Prend le premier utilisateur existant
        $book = Book::first(); // Prend le premier livre existant

        if (!$user || !$book) {
            $this->command->info('⚠️ Aucun utilisateur ou livre trouvé. Ajoute des données avant de lancer le seeder.');
            return;
        }

        // Créer un emprunt en retard (due_date dépassée)
        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => Carbon::now()->subDays(20), // Emprunté il y a 20 jours
            'due_date' => Carbon::now()->subDays(10), // Devait être rendu il y a 10 jours
            'returned_at' => null, // Pas encore retourné
        ]);

        $this->command->info('✅ Emprunt en retard créé avec succès !');
    }
}
