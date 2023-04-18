<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SubmissionStatuses;
use App\Http\Requests\UploadPrescriptionRequest;
use App\Models\Submission;
use App\Notifications\PrescriptionUploaded;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UploadPrescriptionController extends Controller
{
    public function __invoke(UploadPrescriptionRequest $request, Submission $submission): JsonResponse
    {
        $extension = $request->file('prescription')->extension();
        $mimeType = $request->file('prescription')->getMimeType();

        $path = Storage::putFileAs(
            config('filesystems.disks.do_spaces.folder'),
            $request->file('prescription'),
            $submission->id . '.' . $extension
        );

        $submission->prescription()->create([
            'name' => $submission->id . '.' . $extension,
            'path' => $path,
            'mime_type' => $mimeType,
            'size' => $request->file('prescription')->getSize()
        ]);

        $submission->status = SubmissionStatuses::Done;
        $submission->save();

        $submission->patient->notify(new PrescriptionUploaded($submission));

        return response()->json($submission);
    }
}
