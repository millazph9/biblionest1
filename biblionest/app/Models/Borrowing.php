<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

protected $fillable = ['adherent_id', 'book_id', 'borrowed_at', 'due_date', 'returned_at'];
    protected $dates = ['borrowed_at', 'due_date', 'returned_at']; // Pour formater correctement les dates


    public function adherent()
    {
        return $this->belongsTo(Adherent::class, 'adherent_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function penalty()
    {
        return $this->hasOne(Penalty::class);
    }



}

