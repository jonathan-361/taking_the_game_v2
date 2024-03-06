<?php

namespace App\Http\Controllers;

use App\Models\Allowed_Element;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Element;

class AllowedElementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $allowed_elements = Allowed_Element::with(['role', 'permission', 'element'])->get();
        $data = $allowed_elements->map(function ($allowed_element) {
            return [
                'id' => $allowed_element->id,
                'role' => $allowed_element->role->role_name,
                'permission' => $allowed_element->permission->permission_name,
                'element' => $allowed_element->element->element_name,
                'created_at' => $allowed_element->created_at,
                'updated_at' => $allowed_element->updated_at,
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
            'permission_name' => 'required|string',
            'element_name' => 'required|string',
        ]);
        $role = Role::firstOrCreate(['role_name' => $request->role_name]);
        $permission = Permission::firstOrCreate(['permission_name' => $request->permission_name]);
        $element = Element::firstOrCreate(['element_name' => $request->element_name]);

        $allowed_element = new Allowed_Element();
        $allowed_element->role_id = $role->id;
        $allowed_element->permission_id = $permission->id;
        $allowed_element->element_id = $element->id;
        $allowed_element->save();
        $data = [
            'message' => 'Allowed Element created successfully',
            'allowed_element' => [
                'id' => $allowed_element->id,
                'role' => $allowed_element->role->role_name,
                'permission' => $allowed_element->permission->permission_name,
                'element' => $allowed_element->element->element_name,
                'created_at' => $allowed_element->created_at,
                'updated_at' => $allowed_element->updated_at,
            ],
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Allowed_Element $allowed_Element)
    {
        //
        $data = [
            'message' => 'Allowed Element details',
            'allowed_element' => [
                'id' => $allowed_Element->id,
                'role' => $allowed_Element->role->role_name,
                'permission' => $allowed_Element->permission->permission_name,
                'element' => $allowed_Element->element->element_name,
                'created_at' => $allowed_Element->created_at,
                'updated_at' => $allowed_Element->updated_at,
            ],
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allowed_Element $allowed_Element)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allowed_Element $allowed_Element)
    {
        //
        $request->validate([
            'role_name' => 'required|string',
            'permission_name' => 'required|string',
            'element_name' => 'required|string',
        ]);
        $role = Role::firstOrCreate(['role_name' => $request->role_name]);
        $permission = Permission::firstOrCreate(['permission_name' => $request->permission_name]);
        $element = Element::firstOrCreate(['element_name' => $request->element_name]);
        $allowed_Element->role_id = $role->id;
        $allowed_Element->permission_id = $permission->id;
        $allowed_Element->element_id = $element->id;
        $allowed_Element->save();
        $data = [
            'message' => 'Allowed Element updated successfully',
            'allowed_element' => $allowed_Element,
        ];
    
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allowed_Element $allowed_Element)
    {
        //
        $allowed_Element->delete();
        $data = [
            'message' => 'Allowed Element deleted successfully',
            'allowed_element' => [
                'id' => $allowed_Element->id,
                'role' => $allowed_Element->role->role_name,
                'permission' => $allowed_Element->permission->permission_name,
                'element' => $allowed_Element->element->element_name,
                'created_at' => $allowed_Element->created_at,
                'updated_at' => $allowed_Element->updated_at,
            ],
        ];
        return response()->json($data);
    }
}
