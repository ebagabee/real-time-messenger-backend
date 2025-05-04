<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->merge([
            'password' => bcrypt($request->password)
        ]);

        $user = User::create($request->validated());

        $success['token'] = $user->createToken('chatApp')->plainTextToken;
        $success['user'] = new UserResource($user);

        return response()->json([
            'user' => $success['user'],
            'token' => $success['token']
        ], 201);
    }
}
