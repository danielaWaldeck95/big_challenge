<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LogoutController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json('Successfully logged out', Response::HTTP_OK);
    }
}
