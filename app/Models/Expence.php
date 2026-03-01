<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expence extends Model
{
    use HasFactory;

    protected $fillable = [
        'colocation_id',
        'payer_id',
        'title',
        'amount',
        'expence_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expence_date' => 'date',
    ];

    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }

    public function payer(){
        return $this->belongsTo(User::class,'payer_id');
    }
}
