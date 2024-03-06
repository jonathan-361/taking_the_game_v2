<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = Users::with('role')->get();

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'first_surname' => $user->first_surname,
                'second_surname' => $user->second_surname,
                'password' => $user->password,
                'date_of_birth' => $user->date_of_birth,
                'gender' => $user->gender,
                'email' => $user->email,
                'phone' => $user->phone,
                'role_name' => $user->role->role_name,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
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
        $user = new Users;
        $user->name = $request->name;
        $user->first_surname = $request->first_surname;
        $user->second_surname = $request->second_surname;
        $user->password = $request->password;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $role = Role::where('role_name', $request->role_name)->first();

        if ($role) {
            $user->role()->associate($role);
            $user->save();
            $data = [
                'message' => 'User created successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'first_surname' => $user->first_surname,
                    'second_surname' => $user->second_surname,
                    'password' => $user->password,
                    'date_of_birth' => $user->date_of_birth,
                    'gender' => $user->gender,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role_name' => $role->role_name, // Agregar el nombre del rol directamente
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ],
            ];

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Role not found'], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        //
        $data = [
            'id' => $users->id,
            'name' => $users->name,
            'first_surname' => $users->first_surname,
            'second_surname' => $users->second_surname,
            'password' => $users->password,
            'date_of_birth' => $users->date_of_birth,
            'gender' => $users->gender,
            'email' => $users->email,
            'phone' => $users->phone,
            'role_name' => $users->role->role_name,
            'created_at' => $users->created_at,
            'updated_at' => $users->updated_at,
        ];
    
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        //
        $users->name = $request->name;
        $users->first_surname = $request->first_surname;
        $users->second_surname = $request->second_surname;
        $users->password = $request->password;
        $users->date_of_birth = $request->date_of_birth;
        $users->gender = $request->gender;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $role = Role::where('role_name', $request->role_name)->first();

        if ($role) {
            $users->role()->associate($role);
            $users->save();
            $data = [
                'message' => 'User updated successfully',
                'user' => [
                    'id' => $users->id,
                    'name' => $users->name,
                    'first_surname' => $users->first_surname,
                    'second_surname' => $users->second_surname,
                    'password' => $users->password,
                    'date_of_birth' => $users->date_of_birth,
                    'gender' => $users->gender,
                    'email' => $users->email,
                    'phone' => $users->phone,
                    'role_name' => $role->role_name, // Agregar el nombre del rol directamente
                    'created_at' => $users->created_at,
                    'updated_at' => $users->updated_at,
                ],
            ];

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Role not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        //
        $deletedUser = $users->toArray(); // Guardar la información del usuario antes de eliminarlo
        $users->delete();
        $data = [
            'message' => 'User deleted successfully',
            'user' => $deletedUser
        ];

        return response()->json($data);
    }
}
