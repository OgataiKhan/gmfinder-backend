<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMaster extends Model
{
    use HasFactory;

    protected $table = 'game_masters';

    protected $fillable = [
        'user_id', 'location', 'game_description', 'max_players', 'profile_img', 'is_active', 'is_available', 'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
