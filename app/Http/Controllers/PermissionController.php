<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permission = Permission::all();
        return response()->json($permission);
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
        $permission = new Permission;
        $permission->permission_name = $request->permission_name;
        $permission->save();
        $data = [
            'message' => 'Permission created successfully',
            'permission' => $permission
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
        return response()->json($permission);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
        $permission->permission_name = $request->permission_name;
        $permission->save();
        $data = [
            'message' => 'Permission updated successfully',
            'permission' => $permission
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
        $permission->delete();
        $data = [
            'message' => 'Permission deleted successfully',
            'permission' => $permission
        ];
        return response()->json($data);
    }
}
