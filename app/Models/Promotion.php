<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'game_master_id'];

    public function gameMaster()
    {
        return $this->belongsTo(GameMaster::class);
    }
}
