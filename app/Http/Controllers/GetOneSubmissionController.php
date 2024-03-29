<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ShowOneSubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class GetOneSubmissionController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ShowOneSubmissionRequest $request, Submission $submission): JsonResponse
    {
        return response()->json($submission);
    }
}
