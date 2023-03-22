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
        $isDoctor = $this->user()->hasRole(UserTypes::DOCTOR->value);

        if ($isDoctor) {
            return true;
        }

        return $this->submission->patient_id === $this->user()->id;
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
}

