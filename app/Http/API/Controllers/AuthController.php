<?php

namespace App\Http\API\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;


class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|max:16'
            ]);
            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error validation',
                    'errors' =>  $validateUser->errors()
                ], 401);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Successfully created user',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 201);
        } catch (Throwable $ex) {
            return response()->json([
                'status' => false,
                'messaage' => $ex->getMessage()
            ], 500);
        }
    }
    /**
     * Login User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error validation',
                    'errors' =>  $validateUser->errors()
                ], 401);
            }
            if(!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record'
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Successfully logged in user',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 201);
        } catch (Throwable $ex) {
            return response()->json([
                'status' => false,
                'messaage' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user data
     */
    public function getAuthenticatedUser()
    {
        return Auth::user();
    }

    /**
     * Logout user
     */
    public function logout() 
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User loggedout'
        ], 200);
    }
    
}
