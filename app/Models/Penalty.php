<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = ['borrowing_id', 'amount', 'paid', 'paid_at'];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}

