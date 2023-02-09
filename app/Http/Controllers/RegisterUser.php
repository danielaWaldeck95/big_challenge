<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisterUser
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        $user->assignRole($request['user_type']);

        return response()->json('User registered successfully', Response::HTTP_OK);
    }
}
