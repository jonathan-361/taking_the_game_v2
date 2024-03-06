<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match_Results extends Model
{
    use HasFactory;
    protected $table = 'match_results';
    protected $fillable = ['goals_scored_home_team','goals_scored_away_team','match_id','home_team_id','away_team_id'];

    public function match()
    {
        return $this->belongsTo(Matche::class, 'match_id');
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
