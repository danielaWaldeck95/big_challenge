<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserTypes;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetOneSubmissionController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Submission $submission): JsonResponse
    {
        $belongsToPatient = $submission->patient_id === $request->user()->id;

        if ($request->user()->hasRole(UserTypes::PATIENT->value) && !$belongsToPatient) {
            return response()->json(['message' => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }
        return response()->json($submission);
    }
}
