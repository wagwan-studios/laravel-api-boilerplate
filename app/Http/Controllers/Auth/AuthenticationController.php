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
        $user = $request->validated();
        try {
            $this->authService->register($user);
            $this->apiresponse->responseCreated('User Created Successfully');
        } catch (\Exception $th) {
            return $this->apiresponse->responseError($th->getMessage());
        }
    }

    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();
        return $this->apiresponse->responseSuccess(null, 'You Have Been Successfully Logout!');
    }
}
