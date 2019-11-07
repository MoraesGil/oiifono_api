<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use App\Entities\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public $loginAfterSignUp = true;

    public function register(RegisterAuthRequest $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($data) {
            $user  = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // $person = $user->person()->create([
            //     'name' => $data['name'],
            // ]);

            // $individual = $person->individual()->create([
            //     'cpf' => $data['cpf'],
            // ]);

            // $doctor = $person->doctor()->create([
            //     'register' => $data['register'],
            // ]);
        });

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {

            return response()->json([
                'success' => false,
                'message' => trans('auth.failed'),
            ], 401);
        }

        $objectToken = JWTAuth::setToken($jwt_token);
        $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');

        return response()->json([
            'access_token' => $jwt_token,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ]);
    }

    public function logout()
    {
        try {
            auth()->logout();

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function getAuthUser()
    {
        return auth()->user();
    }
}
