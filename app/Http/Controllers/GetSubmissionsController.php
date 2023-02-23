<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetSubmissionsController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): JsonResponse
    {
        $submissions = $request->user()->submissions()->get();

        $response = [
            'submissions' => $submissions,
            'message' => 'Submissions retrieved successfully'
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
