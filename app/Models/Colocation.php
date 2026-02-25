<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'owner_id',
    ];

    public function owner(){
        return $this->belongsTo(User::class ,'owner_id');
    }

    public function memberShips(){
        return $this->hasMany(MemberShip::class);
    }

    public function users(){
        return $this->belongsToMany(User::class , 'memberShips')->withPivot(['role','joined_at'])->withTimestamps();
    }
}
