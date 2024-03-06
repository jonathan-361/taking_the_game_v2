<?php

namespace App\Http\Controllers;

use App\Models\Matche;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Team;

class MatcheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $matches = Matche::with(['homeTeam', 'awayTeam', 'tournament'])->get();
        $data = $matches->map(function ($matche) {
            return [
                'id' => $matche->id,
                'match_date' => $matche->match_date,
                'place' => $matche->place,
                'home_team' => $matche->homeTeam->name,
                'away_team' => $matche->awayTeam->name,
                'tournament' => $matche->tournament->name,
                'created_at' => $matche->created_at,
                'updated_at' => $matche->updated_at,
            ];
        });

        return response()->json(['matche' => $data]);
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
            'place' => 'required|string',
            'home_team' => 'required|string|exists:teams,name',
            'away_team' => 'required|string|exists:teams,name',
            'tournament' => 'required|string|exists:tournaments,name',
        ]);
    
        $homeTeamId = Team::where('name', $request->input('home_team'))->value('id');
        $awayTeamId = Team::where('name', $request->input('away_team'))->value('id');
        $tournamentId = Tournament::where('name', $request->input('tournament'))->value('id');
    
        $matche = Matche::create([
            'match_date' => $request->input('match_date'),
            'place' => $request->input('place'),
            'home_team_id' => $homeTeamId,
            'away_team_id' => $awayTeamId,
            'tournament_id' => $tournamentId,
        ]);
    
        $data = [
            'message' => 'Match created successfully',
            'matche' => [
                'id' => $matche->id,
                'match_date' => $matche->match_date,
                'place' => $matche->place,
                'home_team' => $request->input('home_team'),
                'away_team' => $request->input('away_team'),
                'tournament' => $request->input('tournament'),
                'created_at' => $matche->created_at,
                'updated_at' => $matche->updated_at,
            ],
        ];
    
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Matche $matche)
    {
        //
        $matche->load('homeTeam', 'awayTeam', 'tournament');

        // Accede a los datos del torneo y equipos a través de las relaciones
        $data = [
            'id' => $matche->id,
            'match_date' => $matche->match_date,
            'place' => $matche->place,
            'home_team' => $matche->homeTeam->name,
            'away_team' => $matche->awayTeam->name,
            'tournament' => $matche->tournament->name,
            'created_at' => $matche->created_at,
            'updated_at' => $matche->updated_at,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matche $matche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matche $matche)
    {
        //
        $validatedData = $request->validate([
            'match_date' => 'required|date',
            'place' => 'required|string',
            'home_team' => 'required|string',
            'away_team' => 'required|string',
            'tournament' => 'required|string',
        ]);
    
        // Actualiza los datos del partido
        $matche->update([
            'match_date' => $validatedData['match_date'],
            'place' => $validatedData['place'],
        ]);
    
        // Actualiza las relaciones con los equipos y el torneo
        $homeTeam = Team::firstOrCreate(['name' => $validatedData['home_team']]);
        $awayTeam = Team::firstOrCreate(['name' => $validatedData['away_team']]);
        $tournament = Tournament::firstOrCreate(['name' => $validatedData['tournament']]);
    
        $matche->homeTeam()->associate($homeTeam);
        $matche->awayTeam()->associate($awayTeam);
        $matche->tournament()->associate($tournament);
    
        // Guarda los cambios
        $matche->save();
    
        // Devuelve la respuesta
        $data = [
            'message' => 'Match updated successfully',
            'matche' => [
                'id' => $matche->id,
                'match_date' => $matche->match_date,
                'place' => $matche->place,
                'home_team' => $matche->homeTeam->name,
                'away_team' => $matche->awayTeam->name,
                'tournament' => $matche->tournament->name,
                'created_at' => $matche->created_at,
                'updated_at' => $matche->updated_at,
            ],
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matche $matche)
    {
        //
        $matche->delete();

    // Devuelve la respuesta
        $data = [
            'message' => 'Match deleted successfully',
            'matche' => [
                'id' => $matche->id,
                'match_date' => $matche->match_date,
                'place' => $matche->place,
                'home_team' => $matche->homeTeam->name,
                'away_team' => $matche->awayTeam->name,
                'tournament' => $matche->tournament->name,
                'created_at' => $matche->created_at,
                'updated_at' => $matche->updated_at,
            ],
        ];

        return response()->json($data);
    }
}
