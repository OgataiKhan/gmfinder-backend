<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSystem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description', 'image',
    ];

    public function gameMasters()
    {
        return $this->belongsToMany(GameMaster::class);
    }
}
