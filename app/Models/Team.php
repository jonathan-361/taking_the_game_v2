<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $table = 'teams';
    protected $fillable = ['name', 'team_owner_id', 'logo', 'category_id', 'municipality'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function teamOwner()
    {
        return $this->belongsTo(User::class, 'team_owner_id');
    }
    public function players()
    {
        return $this->hasMany(Player::class);
    }
    public function homeMatches()
    {
        return $this->hasMany(Matche::class, 'home_team_id');
    }
    public function awayMatches()
    {
        return $this->hasMany(Matche::class, 'away_team_id');
    }

    public function homeMatchResults()
    {
        return $this->hasMany(Match_Results::class, 'home_team_id');
    }

    public function awayMatchResults()
    {
        return $this->hasMany(Match_Results::class, 'away_team_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function boot()
    {
        parent::boot();

        // Escuchar el evento deleting para el modelo Team
        static::deleting(function ($team) {
            // Eliminar jugadores relacionados
            $team->players()->delete();

            // Eliminar usuarios relacionados
            $team->players()->each(function ($player) {
                $player->user->delete();
            });
        });
    }
}
