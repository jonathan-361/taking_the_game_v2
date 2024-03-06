<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Models\Category;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tournaments = Tournament::with('category')->get();

        $data = $tournaments->map(function ($tournament) {
            return [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'season' => $tournament->season,
                'category' => $tournament->category->category_name,
                'gender' => $tournament->gender,
                'created_at' => $tournament->created_at,
                'updated_at' => $tournament->updated_at,
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
            'season' => 'required|string',
            'category_name' => 'required|string',
            'gender' => 'required|string',
        ]);

        $category = Category::firstOrCreate(['category_name' => $request->category_name]);
        $category_id = $category->id;

        $tournament = Tournament::create([
            'name' => $request->name,
            'season' => $request->season,
            'gender' => $request->gender,
            'category_id' => $category_id,
        ]);

        $category_name = $category->category_name;

        $data = [
            'message' => 'Tournament created successfully',
            'tournament' => [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'season' => $tournament->season,
                'gender' => $tournament->gender,
                'category_name' => $category_name,
                'created_at' => $tournament->created_at,
                'updated_at' => $tournament->updated_at,
            ],
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        //
        $tournament->load('category');

        $data = [
            'id' => $tournament->id,
            'name' => $tournament->name,
            'season' => $tournament->season,
            'category' => $tournament->category->category_name,
            'gender' => $tournament->gender,
            'created_at' => $tournament->created_at,
            'updated_at' => $tournament->updated_at,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tournament)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'season' => 'required|string',
            'category_name' => 'required|string',
            'gender' => 'required|string',
        ]);
    
        $category = Category::firstOrCreate(['category_name' => $request->category_name]);
        $category_id = $category->id;
    
        $tournament->update([
            'name' => $request->name,
            'season' => $request->season,
            'gender' => $request->gender,
            'category_id' => $category_id,
        ]);
    
        $category_name = $category->category_name;
    
        $data = [
            'message' => 'Tournament updated successfully',
            'tournament' => [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'season' => $tournament->season,
                'category_name' => $category_name,
                'gender' => $tournament->gender,
                'created_at' => $tournament->created_at,
                'updated_at' => $tournament->updated_at,
            ],
        ];
    
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        //
        $tournament->load('category');

        // Guardamos la información de la categoría antes de eliminarla
        $category_info = [
            'id' => $tournament->category->id,
            'category_name' => $tournament->category->category_name,
            'created_at' => $tournament->category->created_at,
            'updated_at' => $tournament->category->updated_at,
        ];

        // Eliminamos el torneo y automáticamente se eliminarán las relaciones
        $tournament->delete();

        $data = [
            'message' => 'Tournament deleted successfully',
            'tournament' => [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'season' => $tournament->season,
                'category_name' => $tournament->category->category_name,
                'gender' => $tournament->gender,
                'created_at' => $tournament->created_at,
                'updated_at' => $tournament->updated_at,
            ],
        ];

        return response()->json($data);
    }
}
