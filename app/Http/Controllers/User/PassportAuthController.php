<?php

namespace App\Http\Controllers\User;

use App\Enums\HttpResponseCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PassportAuthController extends Controller
{
    public function login(UserAuthRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $result = [
                'user' => UserResource::make($user),
                'token' => $user->createToken('UserToken')->accessToken->token,
            ];

            return response()->success(__('auth.client_login_success'), $result);
        }

        return response()->error(__('auth.failed'), HttpResponseCodes::HttpUnauthorized);
    }
}
