<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class RegisterUser
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreUserRequest $request): Response|ResponseFactory
    {
        $user = User::create($request->validated());

        $user->assignRole($request['user_type']);

        return response('User registered successfully', Response::HTTP_OK);
    }
}
