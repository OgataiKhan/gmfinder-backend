<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMaster extends Model
{
    use HasFactory;

    protected $table = 'game_masters';

    protected $fillable = [
        'location', 'game_description', 'max_players', 'profile_img', 'is_available',
    ];

    // Relation with users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation with game_systems
    public function gameSystems()
    {
        return $this->belongsToMany(GameSystem::class);
    }

    // Relation with messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Relation with reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relation with promotions
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    // Check if there's at least one active promotion
    public function getHasActivePromotionAttribute()
    {
        return $this->promotions()->where('end_time', '>', now())->exists();
    }

    // Get the latest promotion's end time
    public function getLatestPromotionEndTimeAttribute()
    {
        $latestPromotion = $this->promotions()->latest('end_time')->first();
        return $latestPromotion ? $latestPromotion->end_time : null;
    }

    // Relation with ratings
    public function ratings()
    {
        return $this->belongsToMany(Rating::class, 'game_master_rating');
    }
}
