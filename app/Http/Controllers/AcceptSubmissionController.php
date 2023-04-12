<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AcceptSubmissionController
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Submission $pendingSubmission): JsonResponse
    {
        $pendingSubmission->update([
            'doctor_id' => $request->user()->id,
            'status' => SubmissionStatuses::InProgress
        ]);

        return response()->json('Submission accepted successfully');
    }
}
