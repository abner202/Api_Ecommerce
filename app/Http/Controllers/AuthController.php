<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
    public function login(Request $request){

    }
    public function logout(Request $request){

    }
}
