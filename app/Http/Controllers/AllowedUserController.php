<?php

namespace App\Http\Controllers;

use App\Models\Allowed_User;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Users;

class AllowedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $allowed_User = Allowed_User::with(['user', 'role'])->get();
        $data = $allowed_User->map(function ($allowed_User) {
            $user = $allowed_User->user;
            $fullName = "{$user->name} {$user->first_surname} {$user->second_surname}";

            return [
                'id' => $allowed_User->id,
                'user' => $fullName,
                'role' => $allowed_User->role->role_name,
                'created_at' => $allowed_User->created_at,
                'updated_at' => $allowed_User->updated_at,
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
            'first_surname' => 'required|string',
            'second_surname' => 'required|string',
            'role_name' => 'required|string',
        ]);
    
        // Buscar o crear el usuario
        $user = Users::firstOrCreate([
            'name' => $request->name,
            'first_surname' => $request->first_surname,
            'second_surname' => $request->second_surname,
        ]);
    
        // Buscar o crear el rol
        $role = Role::firstOrCreate(['role_name' => $request->role_name]);
    
        // Crear la relación Allowed_User
        $allowed_User = new Allowed_User();
        $allowed_User->user_id = $user->id;
        $allowed_User->role_id = $role->id;
        $allowed_User->save();
    
        $fullName = "{$user->name} {$user->first_surname} {$user->second_surname}";
    
        $data = [
            'message' => 'Allowed User created successfully',
            'allowed_user' => [
                'id' => $allowed_User->id,
                'user' => $fullName,
                'role' => $allowed_User->role->role_name,
                'created_at' => $allowed_User->created_at,
                'updated_at' => $allowed_User->updated_at,
            ],
        ];
    
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Allowed_User $allowed_User)
    {
        //
        $user = $allowed_User->user;
        $fullName = "{$user->name} {$user->first_surname} {$user->second_surname}";

        $data = [
            'message' => 'Allowed User details',
            'allowed_user' => [
                'id' => $allowed_User->id,
                'user' => $fullName,
                'role' => $allowed_User->role->role_name,
                'created_at' => $allowed_User->created_at,
                'updated_at' => $allowed_User->updated_at,
            ],
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allowed_User $allowed_User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allowed_User $allowed_User)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'first_surname' => 'required|string',
            'second_surname' => 'required|string',
            'role_name' => 'required|string',
        ]);
    
        // Buscar o crear el usuario
        $user = Users::firstOrCreate([
            'name' => $request->name,
            'first_surname' => $request->first_surname,
            'second_surname' => $request->second_surname,
        ]);
    
        // Buscar o crear el rol
        $role = Role::firstOrCreate(['role_name' => $request->role_name]);
    
        // Actualizar la relación Allowed_User
        $allowed_User->user_id = $user->id;
        $allowed_User->role_id = $role->id;
        $allowed_User->save();
    
        $fullName = "{$user->name} {$user->first_surname} {$user->second_surname}";
    
        $data = [
            'message' => 'Allowed User updated successfully',
            'allowed_user' => [
                'id' => $allowed_User->id,
                'user' => $fullName,
                'role' => $allowed_User->role->role_name,
                'created_at' => $allowed_User->created_at,
                'updated_at' => $allowed_User->updated_at,
            ],
        ];
    
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allowed_User $allowed_User)
    {
        //
        $fullName = "{$allowed_User->user->name} {$allowed_User->user->first_surname} {$allowed_User->user->second_surname}";
        $allowed_User->delete();
        $data = [
            'message' => 'Allowed User deleted successfully',
            'allowed_user' => [
                'id' => $allowed_User->id,
                'user' => $fullName,
                'role' => $allowed_User->role->role_name,
                'created_at' => $allowed_User->created_at,
                'updated_at' => $allowed_User->updated_at,
            ],
        ];
        return response()->json($data);
    }
}
