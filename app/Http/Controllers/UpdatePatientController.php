<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdatePatientController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdatePatientRequest $request): JsonResponse
    {
        $request->user()->update($request->validated());
        return response()->json(['message'=>'Patient updated successfully'], Response::HTTP_OK);
    }
}
