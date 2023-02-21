<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StoreSubmission
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreSubmissionRequest $request): JsonResponse
    {
        $request->user()->submissions()->create($request->validated());
        return response()->json(['message' => 'Submission created successfully'], Response::HTTP_OK);
    }
}
