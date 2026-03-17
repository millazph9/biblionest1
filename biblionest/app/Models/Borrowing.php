<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book; // ✅ Ajout de l'import du modèle Book

class Borrowing extends Model
{
    
    protected $fillable = [
        'adherent_id',
        'book_id',
        'due_date',
        'returned_at',
        // ajoute ici tous les champs que tu veux autoriser
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function adherent()
{
    return $this->belongsTo(User::class);
}



}
