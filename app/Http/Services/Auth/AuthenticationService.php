<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationService {

    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function login($request){
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            $user = Auth::user();
            $data['token'] = 'Bearer ' .$user->createToken('App Access')->accessToken;
            $data['user'] = $user;
            return $data;
        }
    }

    public function register($request){
        return $this->user->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);
    }
}
