<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserTypes;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create submissions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:2'],
            'symptoms' => ['required', 'min:2', 'max:500'],
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('This action is unauthorized. User must be of type:'
        . strtolower(UserTypes::PATIENT->value) . ' in order to create submissions');
    }
}
