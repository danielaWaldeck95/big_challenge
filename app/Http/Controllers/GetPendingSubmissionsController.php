<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetPendingSubmissionsController
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): LengthAwarePaginator
    {
        return Submission::where('status', SubmissionStatuses::Pending)->paginate();
    }
}
