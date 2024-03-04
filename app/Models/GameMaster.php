<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMaster extends Model
{
    use HasFactory;

    protected $table = 'game_masters';

    protected $fillable = [
        'location', 'game_description', 'max_players', 'profile_img', 'is_active', 'is_available',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameSystems()
    {
        return $this->belongsToMany(GameSystem::class, 'game_master_game_system', 'game_master_id', 'game_system_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
