<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Element;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menu = Menu::with(['role', 'element'])->get();
        $data = $menu->map(function ($menu) {
            return [
                'id' => $menu->id,
                'role' => $menu->role->role_name,
                'element' => $menu->element->element_name,
                'created_at' => $menu->created_at,
                'updated_at' => $menu->updated_at,
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
            'role_name' => 'required|string',
            'element_name' => 'required|string',
        ]);
        $role = Role::firstOrCreate(['role_name' => $request->role_name]);
        $element = Element::firstOrCreate(['element_name' => $request->element_name]);

        $menu = new Menu();
        $menu->role_id = $role->id;
        $menu->element_id = $element->id;
        $menu->save();
        $data = [
            'message' => 'Menu created successfully',
            'menu' => [
                'id' => $menu->id,
                'role' => $menu->role->role_name,
                'element' => $menu->element->element_name,
                'created_at' => $menu->created_at,
                'updated_at' => $menu->updated_at,
            ],
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
        $data = [
            'message' => 'Menu details',
            'menu' => [
                'id' => $menu->id,
                'role' => $menu->role->role_name,
                'element' => $menu->element->element_name,
                'created_at' => $menu->created_at,
                'updated_at' => $menu->updated_at,
            ],
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
        $request->validate([
            'role_name' => 'required|string',
            'element_name' => 'required|string',
        ]);
        $role = Role::firstOrCreate(['role_name' => $request->role_name]);
        $element = Element::firstOrCreate(['element_name' => $request->element_name]);
        $menu->role_id = $role->id;
        $menu->element_id = $element->id;
        $menu->save();
        $data = [
            'message' => 'Menu updated successfully',
            'menu' => $menu,
        ];
    
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
        $menu->delete();
        $data = [
            'message' => 'Menu deleted successfully',
            'menu' => [
                'id' => $menu->id,
                'role' => $menu->role->role_name,
                'element' => $menu->element->element_name,
                'created_at' => $menu->created_at,
                'updated_at' => $menu->updated_at,
            ],
        ];
        return response()->json($data);
    }
}
