<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $players = Player::with('user', 'team')->get();

        $data = $players->map(function ($player) {
            return [
                'id' => $player->id,
                'user_name' => $player->user->name,
                'team_name' => $player->team->name,
                'player_photo' => $player->player_photo,
                'team_role' => $player->team_role,
                'weight' => $player->weight,
                'height' => $player->height,
                'created_at' => $player->created_at,
                'updated_at' => $player->updated_at,
            ];
        });

        return response()->json($data);
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
            'user_name' => 'required|string',
            'team_name' => 'required|string',
            'player_photo' => 'required|string',
            'team_role' => 'required|string',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        preg_match('/^(?<name>[^\d]+) (?<first_surname>[^\d]+) (?<second_surname>.+)$/', $request->user_name, $matches);

        $playerUserName = $matches['name'] ?? '';
        $playerUserFirstSurname = $matches['first_surname'] ?? '';
        $playerUserSecondSurname = $matches['second_surname'] ?? '';

        $user = User::where('name', 'like', $playerUserName . '%')
            ->where('first_surname', 'like', $playerUserFirstSurname . '%')
            ->where('second_surname', 'like', $playerUserSecondSurname . '%')
            ->first();

        if (!$user || $user->role_id !== 4) {
            return response()->json(['error' => 'El usuario no tiene el rol necesario para ser un jugador.'], 403);
        }

        $team = Team::where('name', $request->team_name)->first();

        if (!$team) {
            return response()->json(['error' => 'No se encontró el equipo especificado.'], 404);
        }

        $player = new Player;
        $player->user_id = $user->id;
        $player->team_id = $team->id;
        $player->player_photo = $request->player_photo;
        $player->team_role = $request->team_role;
        $player->weight = $request->weight;
        $player->height = $request->height;
        $player->save();

        $data = [
            'message' => 'Jugador creado exitosamente',
            'player' => [
                'id' => $player->id,
                'user_name' => $user->name . ' ' . $user->first_surname . ' ' . $user->second_surname,
                'team_name' => $team->name,
                'player_photo' => $player->player_photo,
                'team_role' => $player->team_role,
                'weight' => $player->weight,
                'height' => $player->height,
                'created_at' => $player->created_at,
                'updated_at' => $player->updated_at,
            ],
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        //
        $player->load('user', 'team');

        $data = [
            'id' => $player->id,
            'user_name' => $player->user ? $player->user->name . ' ' . $player->user->first_surname . ' ' . $player->user->second_surname : null,
            'team_name' => $player->team ? $player->team->name : null,
            'player_photo' => $player->player_photo,
            'team_role' => $player->team_role,
            'weight' => $player->weight,
            'height' => $player->height,
            'created_at' => $player->created_at,
            'updated_at' => $player->updated_at,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        //
        $request->validate([
            'user_name' => 'required|string',
            'team_name' => 'required|string',
            'player_photo' => 'required|string',
            'team_role' => 'required|string',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        preg_match('/^(?<name>[^\d]+) (?<first_surname>[^\d]+) (?<second_surname>.+)$/', $request->user_name, $matches);

        $playerUserName = $matches['name'] ?? '';
        $playerUserFirstSurname = $matches['first_surname'] ?? '';
        $playerUserSecondSurname = $matches['second_surname'] ?? '';

        $user = User::where('name', 'like', $playerUserName . '%')
            ->where('first_surname', 'like', $playerUserFirstSurname . '%')
            ->where('second_surname', 'like', $playerUserSecondSurname . '%')
            ->first();

        if (!$user || $user->role_id !== 4) {
            return response()->json(['error' => 'El usuario no tiene el rol necesario para ser un jugador.'], 403);
        }

        $team = Team::where('name', $request->team_name)->first();

        if (!$team) {
            return response()->json(['error' => 'No se encontró el equipo especificado.'], 404);
        }

        $player->user_id = $user->id;
        $player->team_id = $team->id;
        $player->player_photo = $request->player_photo;
        $player->team_role = $request->team_role;
        $player->weight = $request->weight;
        $player->height = $request->height;
        $player->save();

        $data = [
            'message' => 'Player updated successfully',
            'player' => [
                'id' => $player->id,
                'user_name' => $user->name . ' ' . $user->first_surname . ' ' . $user->second_surname,
                'team_name' => $team->name,
                'player_photo' => $player->player_photo,
                'team_role' => $player->team_role,
                'weight' => $player->weight,
                'height' => $player->height,
                'created_at' => $player->created_at,
                'updated_at' => $player->updated_at,
            ],
        ];

        return response()->json($data, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        //
        $player->delete();

        $data = [
            'message' => 'Player deleted successfully',
            'player' => [
                'id' => $player->id,
                'user_name' => $player->user ? $player->user->name . ' ' . $player->user->first_surname . ' ' . $player->user->second_surname : null,
                'team_name' => $player->team ? $player->team->name : null,
                'player_photo' => $player->player_photo,
                'team_role' => $player->team_role,
                'weight' => $player->weight,
                'height' => $player->height,
                'created_at' => $player->created_at,
                'updated_at' => $player->updated_at,
            ],
        ];

        return response()->json($data);
    }
}
