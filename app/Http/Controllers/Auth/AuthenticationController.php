<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\APIHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\Auth\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            return $this->apiresponse->responseSuccess($data, 'Login Successfully');

        } catch (\Exception $th) {
            return $this->apiresponse->responseError($th->getMessage());
        }
    }

    public function register(RegisterRequest $request){
        $user = $request->validated();
        try {
            $this->authService->register($user);
            return $this->apiresponse->responseCreated('User Created Successfully');
        } catch (\Exception $th) {
            return $this->apiresponse->responseError($th->getMessage());
        }
    }

    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();
        return $this->apiresponse->responseSuccess(null, 'You Have Been Successfully Logout!');
    }

    public function forgotPassword(Request $request){
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return $this->apiresponse->responseError($validator->errors());
        }
        $response = Password::sendResetLink($input);
        return $this->apiresponse->responseSuccess(null, 'Email sent successfully');
    }

    public function reset() {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["msg" => "Invalid token provided"], 400);
        }

        return response()->json(["msg" => "Password has been successfully changed"]);
    }
}
