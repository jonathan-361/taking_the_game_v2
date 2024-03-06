<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    use HasFactory;
    protected $table = 'matches';
    protected $fillable = ['match_date','place','home_team_id','away_team_id','tournament_id'];

    protected $casts = [
        'match_date' => 'datetime',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function homeMatchResult()
    {
        return $this->hasOne(Match_Results::class, 'match_id')->where('home_team_id', $this->home_team_id);
    }

    public function awayMatchResult()
    {
        return $this->hasOne(Match_Results::class, 'match_id')->where('away_team_id', $this->away_team_id);
    }
}
