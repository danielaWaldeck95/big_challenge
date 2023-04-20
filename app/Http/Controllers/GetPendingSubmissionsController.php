<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPendingSubmissionsController
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): JsonResponse
    {
        $submissions = Submission::where('status', SubmissionStatuses::Pending)->paginate();

        return response()->json($submissions);
    }
}
