<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required|confirmed",
            "location" => "required"
        ]);

        $new_sec = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "address" => $request->location['address'],
            "long" => $request->location['position']['lng'],
            "lat" => $request->location['position']['lat'],
        ]);

        return $new_sec;
    }

    public function update(User $user,Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "location" => "required"
        ]);

        $user->update([
            "name" => $request->name,
            "email" => $request->email,
            "address" => $request->location['address'],
            "long" => $request->location['position']['lng'],
            "lat" => $request->location['position']['lat'],
        ]);

        if($request->password) {

            if($request->password != $request->password_confirmation) 
                return response()->json([
                    "message"=> "Password does not match",
                    "errors" => ["password" => ["Password does not match."]]
                ], 422);
            
            $user->update([
                "password" => bcrypt($request->password),
            ]);
        }

        return $user;

    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            $success['id'] =  $user->id;
   
            return $success;
        } 
        else{ 
            return ['error'=>'Unauthorised'];
        } 
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return "success";
    }
}
