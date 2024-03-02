<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSystem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description', 'image', 'slug'
    ];

    public function gameMasters()
    {
        return $this->belongsToMany(GameMaster::class, 'game_master_game_system', 'game_system_id', 'game_master_id');
    }
}
