<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSubmissionsController
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): JsonResponse
    {
        $status = $request->input('status');
        $submissions = $request
            ->user()
            ->submissions()
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->paginate();

        return response()->json($submissions);
    }
}
