<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationService {

    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function login($request){
        if(Auth::guard('api')->attempt($request->email, $request->password)){
            $user = $this->user->where('email', $request->email)->first();
            $data['token'] = $user->createToken('Token Name')->accessToken;
            $data['user'] = $user;
            return $data;
        }
    }

    public function register($request){
        return $this->user->create($request->only($this->user->getFillable()));
    }
}
