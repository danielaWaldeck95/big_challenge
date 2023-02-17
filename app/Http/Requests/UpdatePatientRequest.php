<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('update personal information');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'min:9'],
            'weight' => ['required'],
            'height' => ['required'],
            'other_information' => ['sometimes', 'nullable','min:2', 'max:500']
        ];
    }
}
