<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        try{
            $request->validate([
                'name' => ['string', 'required', 'max:255'],
                'email' => ['email', 'required', 'string', 'max:255', 'unique:users' ],
                'password' => ['string', 'required'],
                'role' => ['string', 'required']
            ]);

            user::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>Hash::make($request->password),
                'role' => $request->role
            ]);

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('CarToken')->plainTextToken;

            $data = [
                'user' => $user,
                'acces_token' => $token,
                'message' => 'Authentication Succes!'
            ];
            return response()->json($data, 200); 

        }catch(Exception $err){
            $data = [
                'error' => $err,
                'message' => 'Upsss!, something went wrong'
            ];

            return response()->json($data, 500);
        }
    }

    public function login(Request $request)
    {
        try{
            $credentials = $request->validate([
                'email' => ['required', 'string'],
                'password' => ['required', 'string']
            ]);
            
            if(!Auth::attempt($credentials)){
                $data=[
                    'message' => 'Authentication Failed'
                ];
                return response()->json($data, 500);
            }

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('CarToken')->plainTextToken;
            $data=[
                'user' => $user,
                'acces_token' => $token,
                'message' => 'Login Success'
            ];

            return response()->json($data, 200);

        }catch(Exception $err){
            $data = [
                'error' => $err,
                'message' => 'Upsss!, something went wrong'
            ];

            return response()->json($data, 500);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        $data=[
            'message' => 'You are logged Out'
        ];
        return response()->json($data, 200);
    }
}
