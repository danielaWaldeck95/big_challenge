<?php

declare(strict_types=1);


namespace App\Http\Requests;

use App\Enums\SubmissionStatuses;
use Illuminate\Foundation\Http\FormRequest;

class UploadPrescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $submissionIsPending = $this->submission->status == SubmissionStatuses::Pending;

        if ($submissionIsPending) {
            return false;
        }

        return $this->submission->doctor_id == $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'prescription' => ['required', 'mimes:txt']
        ];
    }
}
