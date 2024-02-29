<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistroRequest;

class AuthController extends Controller
{
    public function register(RegistroRequest $request){
        //validad el registro
        $data=$request->validated();

        //guardar reg
        $user= User::create ([
            'name'=>$data['name'],
            'email' => $data ['email'],
            'password' => bcrypt($data ['password']),
        ]);

        //Return respuesta
        return [
            'token'=>$user->createToken('token')->plainTextToken,
            'user'=>$user
        ];
    }
    public function login(LoginRequest $request) {
        $data = $request->validated();

        // Revisar el password
        if(!Auth::attempt($data)) {
            return response([
                'errors' => ['El email o el password son incorrectos']
            ], 422);
        }

        // Autenticar al usuario
        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }
}
