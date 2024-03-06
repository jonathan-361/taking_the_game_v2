<?php

namespace App\Http\Controllers;

use App\Models\Match_Results;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Matche;

class MatchResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $match_Results = Match_Results::with(['match', 'homeTeam', 'awayTeam'])->get();

        $data = $match_Results->map(function ($match_Results) {
            return [
                'id' => $match_Results->id,
                'match_id' => $match_Results->match_id,
                'match_date' => $match_Results->match->match_date,
                'home_team' => $match_Results->homeTeam->name,
                'away_team' => $match_Results->awayTeam->name,
                'goals_scored_home_team' => $match_Results->goals_scored_home_team,
                'goals_scored_away_team' => $match_Results->goals_scored_away_team,
                'created_at' => $match_Results->created_at,
                'updated_at' => $match_Results->updated_at,
            ];
        });        

        return response()->json(['match_results' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'match_date' => 'required|date',
            'home_team' => 'required|string',
            'away_team' => 'required|string',
            'goals_scored_home_team' => 'required|integer|min:0',
            'goals_scored_away_team' => 'required|integer|min:0',
        ]);
    
        $matchDate = $request->input('match_date');
        $match = Matche::where('match_date', $matchDate)->first();
    
        if (!$match) {
            return response()->json(['error' => 'Match not found for the given date'], 404);
        }
    
        $homeTeam = Team::firstOrCreate(['name' => $request->input('home_team')]);
        $awayTeam = Team::firstOrCreate(['name' => $request->input('away_team')]);
    
        $matchResult = new Match_Results([
            'match_id' => $match->id,
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'goals_scored_home_team' => $request->input('goals_scored_home_team'),
            'goals_scored_away_team' => $request->input('goals_scored_away_team'),
        ]);
    
        $matchResult->save();

        $data = [
            'message' => 'Match updated successfully',
            'matche' => [
                'match_date' => $match->match_date->toIso8601String(),
                'home_team' => $homeTeam->name,
                'away_team' => $awayTeam->name,
                'goals_scored_home_team' => $matchResult->goals_scored_home_team,
                'goals_scored_away_team' => $matchResult->goals_scored_away_team,
                'updated_at' => $matchResult->updated_at,
                'created_at' => $matchResult->created_at,
                'id' => $matchResult->id,
            ],
        ];
    
        // Retornar la respuesta
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Match_Results $match_Results)
    {
        //
        $match_Results->load('homeTeam', 'awayTeam', 'match');

        $data = [
            'match_date' => $match_Results->match->match_date->toIso8601String(),
            'home_team' => $match_Results->homeTeam->name,
            'away_team' => $match_Results->awayTeam->name,
            'goals_scored_home_team' => $match_Results->goals_scored_home_team,
            'goals_scored_away_team' => $match_Results->goals_scored_away_team,
            'updated_at' => $match_Results->updated_at,
            'created_at' => $match_Results->created_at,
            'id' => $match_Results->id,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Match_Results $match_Results)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Match_Results $match_Results)
    {
        //
        $request->validate([
            'match_date' => 'required|date',
            'home_team' => 'required|string',
            'away_team' => 'required|string',
            'goals_scored_home_team' => 'required|integer|min:0',
            'goals_scored_away_team' => 'required|integer|min:0',
        ]);
    
        // Obtener los equipos según sus nombres
        $homeTeam = Team::firstOrCreate(['name' => $request->input('home_team')]);
        $awayTeam = Team::firstOrCreate(['name' => $request->input('away_team')]);
    
        // Actualizar el resultado del partido existente
        $match_Results->update([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'goals_scored_home_team' => $request->input('goals_scored_home_team'),
            'goals_scored_away_team' => $request->input('goals_scored_away_team'),
        ]);
    
        $data = [
            'message' => 'Match updated successfully',
            'matche' => [
                'match_date' => $match_Results->match->match_date->toIso8601String(),
                'home_team' => $homeTeam->name,
                'away_team' => $awayTeam->name,
                'goals_scored_home_team' => $match_Results->goals_scored_home_team,
                'goals_scored_away_team' => $match_Results->goals_scored_away_team,
                'updated_at' => $match_Results->updated_at,
                'created_at' => $match_Results->created_at,
                'id' => $match_Results->id,
            ],
        ];
    
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Match_Results $match_Results)
    {
        //
        $match_Results->load('homeTeam', 'awayTeam', 'match');
        $match_Results->delete();

        $data = [
            'message' => 'Match result deleted successfully',
            'match_results' => [
                'id' => $match_Results->id,
                'match_date' => $match_Results->match->match_date->toIso8601String(),
                'home_team' => $match_Results->homeTeam ? $match_Results->homeTeam->name : null,
                'away_team' => $match_Results->awayTeam ? $match_Results->awayTeam->name : null,
                'created_at' => $match_Results->created_at,
                'updated_at' => $match_Results->updated_at,
            ],
        ];

        return response()->json($data);
    }
}
