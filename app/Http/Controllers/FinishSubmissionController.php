<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SubmissionStatuses;
use App\Http\Requests\FinishSubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class FinishSubmissionController
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(FinishSubmissionRequest $request, Submission $submission): JsonResponse
    {
        $submission->update([
            'status' => SubmissionStatuses::Done
        ]);

        return response()->json('Submission finished successfully');
    }
}
