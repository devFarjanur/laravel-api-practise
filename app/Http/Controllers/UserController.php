<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Log;
use Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getUser()
    {
        $getUser = User::get();
        return response()->json($getUser);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        try {
            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                return response()->json(['message' => 'Email already exists'], 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);

        } catch (\Exception $e) {
            Log::error('Error occurred while storing user:', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function findUser($id)
    {
        try {

            $findUser = User::find($id);
            return response()->json(['message' => 'User found successfully', 'user' => $findUser], 201);

        } catch (\Exception $e) {
            Log::error('Error occurred while found user:', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        try {

            $deleteUser = $this->findUser($id);

            if (!$deleteUser) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $deleteUser->delete();

            return response()->json(['message' => 'User deleted successfully', 'user' => $deleteUser], 201);

        } catch (\Exception $e) {
            Log::error('Error occurred while deleting user:', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
