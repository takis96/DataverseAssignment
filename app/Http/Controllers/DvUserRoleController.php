<?php

namespace App\Http\Controllers;

use App\Models\DvUserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class DvUserDvUserRoleController extends Controller
{

    public function index()
    {
        try {
            $dvUserRoles = DvUserRole::all();
            return response()->json($dvUserRoles);
        } catch (Exception $e) {
            
            Log::error('Error retrieving DvUserRoles: '.$e->getMessage());
            return response()->json(['error' => 'Failed to retrieve DvUserRoles.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:dv_users_DvUserRoles',
            ]);

            $dvUserRole = DvUserRole::create([
                'name' => $request->name,
                'is_active' => $request->is_active ?? 0,
            ]);

            return response()->json($dvUserRole, 201); 

        } catch (Exception $e) {

            Log::error('Error creating DvUserRole: '.$e->getMessage());


            return response()->json(['error' => 'Failed to create DvUserRole.'], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $dvUserRole = DvUserRole::findOrFail($id);


            $dvUserRole->update($request->all());

            return response()->json($dvUserRole);

        } catch (Exception $e) {

            Log::error('Error updating DvUserRole: '.$e->getMessage());


            return response()->json(['error' => 'Failed to update DvUserRole.'], 500);
        }
    }


    public function destroy($id)
    {
        try {

            DvUserRole::destroy($id);

            return response()->json(['message' => 'DvUserRole deleted'], 200);

        } catch (Exception $e) {

            Log::error('Error deleting DvUserRole: '.$e->getMessage());

            return response()->json(['error' => 'Failed to delete DvUserRole.'], 500);
        }
    }
}
