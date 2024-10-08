<?php

namespace App\Http\Controllers;

use App\Models\DvUserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class DvUserDvUserRoleController extends Controller
{
    // Method to get all DvUserRoles
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

    // Method to create a new DvUserRole
    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|unique:dv_users_DvUserRoles',
            ]);

            // Create the DvUserRole
            $dvUserRole = DvUserRole::create([
                'name' => $request->name,
                'is_active' => $request->is_active ?? 0,
            ]);

            return response()->json($dvUserRole, 201); // 201 for created resource

        } catch (Exception $e) {
            // Log the error
            Log::error('Error creating DvUserRole: '.$e->getMessage());

            // Return a JSON error response
            return response()->json(['error' => 'Failed to create DvUserRole.'], 500);
        }
    }

    // Method to update an existing DvUserRole
    public function update(Request $request, $id)
    {
        try {
            // Find the DvUserRole or throw a 404 error if not found
            $dvUserRole = DvUserRole::findOrFail($id);

            // Update the DvUserRole
            $dvUserRole->update($request->all());

            return response()->json($dvUserRole);

        } catch (Exception $e) {
            // Log the error
            Log::error('Error updating DvUserRole: '.$e->getMessage());

            // Return a JSON error response
            return response()->json(['error' => 'Failed to update DvUserRole.'], 500);
        }
    }

    // Method to delete a DvUserRole
    public function destroy($id)
    {
        try {
            // Delete the DvUserRole
            DvUserRole::destroy($id);

            return response()->json(['message' => 'DvUserRole deleted'], 200);

        } catch (Exception $e) {
            // Log the error
            Log::error('Error deleting DvUserRole: '.$e->getMessage());

            // Return a JSON error response
            return response()->json(['error' => 'Failed to delete DvUserRole.'], 500);
        }
    }
}
