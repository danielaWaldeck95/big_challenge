<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserTypes;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class ShowOneSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $isPatient = $this->user()->hasRole(UserTypes::PATIENT->value);
        $belongsToPatient = $this->submission->patient_id === $this->user()->id;

        return ($isPatient && $belongsToPatient);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('This action is unauthorized. User must be of type:'
        . strtolower(UserTypes::PATIENT->value) . ' and owner of this submission');
    }
}

