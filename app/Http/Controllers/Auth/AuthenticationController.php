<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\APIHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\Auth\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    protected $authService;
    protected $apiresponse;

    public function __construct(AuthenticationService $authService, APIHelper $apiresponse)
    {
        $this->authService = $authService;
        $this->apiresponse = $apiresponse;
    }
    public function login(LoginRequest $request){
        $credentials = $request->validated();
        try {
            $data = $this->authService->login($credentials);
            $this->apiresponse->responseSuccess($data, 'Login Successfully');

        } catch (\Exception $th) {
            return $this->apiresponse->responseError($th->getMessage());
        }
    }

    public function register(RegisterRequest $request){

    }

    public function logout(){

    }
}
