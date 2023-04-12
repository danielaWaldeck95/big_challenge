<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SubmissionStatuses;
use App\Http\Requests\AcceptSubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class AcceptSubmissionController
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AcceptSubmissionRequest $request, Submission $submission): JsonResponse
    {
        $submission->update([
            'doctor_id' => $request->user()->id,
            'status' => SubmissionStatuses::InProgress
        ]);

        return response()->json('Submission accepted successfully');
    }
}
