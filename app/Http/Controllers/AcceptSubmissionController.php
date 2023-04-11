<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SubmissionStatuses;
use App\Http\Requests\AcceptSubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AcceptSubmissionController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AcceptSubmissionRequest $request, Submission $submission): JsonResponse
    {
        $submission->update([
            'doctor_id' => $request->user()->id,
            'status' => SubmissionStatuses::InProgress
        ]);
        return response()->json('Doctor accepted the submission successfully', Response::HTTP_OK);
    }
}
