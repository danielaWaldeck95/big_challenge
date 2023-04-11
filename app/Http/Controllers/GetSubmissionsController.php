<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSubmissionsController
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): JsonResponse
    {
        $submissions = $request->user()->submissions()->paginate();

        return response()->json($submissions);
    }
}
