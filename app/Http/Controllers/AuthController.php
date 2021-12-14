<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $Request)
    {
        $fields = $Request-> validate([
            'name'=> 'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);

        $user =User::create([
            'name' => $fields['name'],
            'email'=> $fields['email'],
            'password'=> bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response =[
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }

    public function login(Request $Request)
    {
        $fields = $Request-> validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);
        //Check Email
       $user = User::where('email',$fields['email'])->first();

       //Check Password
       if(!$user || !Hash::check($fields['password'],$user->password)){
           return response([
               'message' => 'Bad cread'
           ], 401);
       }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response =[
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'logged out'
        ];
    }
}
