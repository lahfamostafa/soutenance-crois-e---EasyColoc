<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'invited_email',
        'colocation_id',
        'token',
        'status',
        'sent_by',
        'expire_at',
    ];

    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }

    public function sender(){
        return $this->belongsTo(User::class, 'sent_by');
    }

    protected $casts = [
        'expire_at' => 'datetime',
    ];
}
