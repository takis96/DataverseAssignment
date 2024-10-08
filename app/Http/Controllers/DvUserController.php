<?php

namespace App\Http\Controllers;

use App\Models\DvUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = DvUser::with('roles')->get();
        return response()->json($users);  
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:dv_users',
            'password' => 'required|min:6',
        ]);

        $user = DvUser::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'is_active' => $request->is_active ?? 0,
        ]);

        return response()->json($user);  
    }

    public function update(Request $request, $id)
    {
        $user = DvUser::findOrFail($id);
        $user->update($request->all());

        return response()->json($user);  
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted']); 
    }

    public function attachRoles(Request $request, $userId)
    {
        try {
            $user = DvUser::findOrFail($userId);

            $request->validate([
                'roles' => 'required|array',
                'roles.*' => 'exists:dv_users_roles,id',
            ]);

            $user->roles()->sync($request->roles);

            return response()->json(['message' => 'Roles attached successfully']);

        } catch (Exception $e) {
            Log::error('Error attaching roles: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to attach roles'], 500);
        }
    }

    public function detachRoles(Request $request, $userId)
    {
        try {
            $user = DvUser::findOrFail($userId);

            $request->validate([
                'roles' => 'required|array',
                'roles.*' => 'exists:dv_users_roles,id',
            ]);

            $user->roles()->detach($request->roles);

            return response()->json(['message' => 'Roles detached successfully'], 200);

        } catch (Exception $e) {
            Log::error('Error detaching roles: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to detach roles'], 500);
        }
    }
}
