<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function me(Request $request)
    {
        return response()->json(auth()->user());
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            if ($token = JWTAuth::attempt($credentials)) {
                return response()->json(['token' => $token]);
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Log or return the error message
            return response()->json(['error' => $e->getMessage()], 401);
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
