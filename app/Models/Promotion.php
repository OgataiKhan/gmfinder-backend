<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [
        'end_time' => 'datetime',
    ];

    public function gameMaster()
    {
        return $this->belongsTo(GameMaster::class);
    }
}
