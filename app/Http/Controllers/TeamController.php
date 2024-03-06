<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $teams = Team::with('category', 'teamOwner')->get();
        $data = $teams->map(function ($team) {
            return [
                'id' => $team->id,
                'name' => $team->name,
                'team_owner' => $team->teamOwner ? $team->teamOwner->name . ' ' . $team->teamOwner->first_surname . ' ' . $team->teamOwner->second_surname : null,
                'logo' => $team->logo,
                'category' => $team->category->category_name,
                'gender' => $team->gender,
                'municipality' => $team->municipality,
                'created_at' => $team->created_at,
                'updated_at' => $team->updated_at,
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
            'name' => 'required|string',
            'team_owner' => 'required|string',
            'logo' => 'required|string',
            'category' => 'required|string',
            'gender' => 'required|string',
            'municipality' => 'required|string',
        ]);

        preg_match('/^(?<name>[^\d]+) (?<first_surname>[^\d]+) (?<second_surname>.+)$/', $request->team_owner, $matches);

        $teamOwnerName = $matches['name'] ?? '';
        $teamOwnerFirstSurname = $matches['first_surname'] ?? '';
        $teamOwnerSecondSurname = $matches['second_surname'] ?? '';

        $user = User::where('name', 'like', $teamOwnerName . '%')
            ->where('first_surname', 'like', $teamOwnerFirstSurname . '%')
            ->where('second_surname', 'like', $teamOwnerSecondSurname . '%')
            ->first();

        if (!$user || $user->role_id !== 3) {
            return response()->json(['error' => 'El usuario no tiene el rol necesario para ser dueño de un equipo.'], 403);
        }

        $category = Category::firstOrCreate(['category_name' => $request->category]);

        $team = new Team;
        $team->name = $request->name;
        $team->team_owner_id = $user->id;
        $team->logo = $request->logo;
        $team->category()->associate($category);
        $team->gender = $request->gender;
        $team->municipality = $request->municipality;
        $team->save();
        $team->load('teamOwner');

        $data = [
            'message' => 'Team created successfully',
            'team' => [
                'id' => $team->id,
                'name' => $team->name,
                'owner_team' => $team->teamOwner ? $team->teamOwner->name . ' ' . $team->teamOwner->first_surname . ' ' . $team->teamOwner->second_surname : null,
                'logo' => $team->logo,
                'category' => $team->category->category_name,
                'gender' => $team->gender,
                'municipality' => $team->municipality,
                'created_at' => $team->created_at,
                'updated_at' => $team->updated_at,
            ],
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
        $team->load('teamOwner', 'category');

        $owner = $team->teamOwner
            ? $team->teamOwner->name . ' ' . $team->teamOwner->first_surname . ' ' . $team->teamOwner->second_surname
            : null;

        $data = [
            'id' => $team->id,
            'name' => $team->name,
            'owner_team' => $owner,
            'logo' => $team->logo,
            'category' => $team->category->category_name,
            'gender' => $team->gender,
            'municipality' => $team->municipality,
            'created_at' => $team->created_at,
            'updated_at' => $team->updated_at,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'team_owner' => 'required|string',
            'logo' => 'required|string',
            'category' => 'required|string',
            'gender' => 'required|string',
            'municipality' => 'required|string',
        ]);

        preg_match('/^(?<name>[^\d]+) (?<first_surname>[^\d]+) (?<second_surname>.+)$/', $request->team_owner, $matches);

        $teamOwnerName = $matches['name'] ?? '';
        $teamOwnerFirstSurname = $matches['first_surname'] ?? '';
        $teamOwnerSecondSurname = $matches['second_surname'] ?? '';

        $user = User::where('name', 'like', $teamOwnerName . '%')
            ->where('first_surname', 'like', $teamOwnerFirstSurname . '%')
            ->where('second_surname', 'like', $teamOwnerSecondSurname . '%')
            ->first();

        if (!$user || $user->role_id !== 3) {
            return response()->json(['error' => 'El usuario no tiene el rol necesario para ser dueño de un equipo.'], 403);
        }

        $category = Category::firstOrCreate(['category_name' => $request->category]);

        $team->name = $request->name;
        $team->team_owner_id = $user->id;
        $team->logo = $request->logo;
        $team->category()->associate($category);
        $team->gender = $request->gender;
        $team->municipality = $request->municipality;
        $team->save();
        $team->load('teamOwner');

        $data = [
            'message' => 'Team updated successfully',
            'team' => [
                'id' => $team->id,
                'name' => $team->name,
                'owner_team' => $team->teamOwner ? $team->teamOwner->name . ' ' . $team->teamOwner->first_surname . ' ' . $team->teamOwner->second_surname : null,
                'logo' => $team->logo,
                'category' => $team->category->category_name,
                'gender' => $team->gender,
                'municipality' => $team->municipality,
                'created_at' => $team->created_at,
                'updated_at' => $team->updated_at,
            ],
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
        $team->delete();

        $data = [
            'message' => 'Team deleted successfully',
            'team' => [
                'id' => $team->id,
                'name' => $team->name,
                'owner_team' => $team->team_owner ? $team->team_owner->name . ' ' . $team->team_owner->first_surname . ' ' . $team->team_owner->second_surname : null,
                'logo' => $team->logo,
                'category' => $team->category->category_name,
                'gender' => $team->gender,
                'municipality' => $team->municipality,
                'created_at' => $team->created_at,
                'updated_at' => $team->updated_at,
            ],
        ];

        return response()->json($data);
    }
}
