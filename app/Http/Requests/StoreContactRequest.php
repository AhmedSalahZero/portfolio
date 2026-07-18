<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:180'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            // Honeypot: real users leave this hidden field empty.
            'website' => ['nullable', 'prohibited'],
        ];
    }

    protected function passedValidation(): void
    {
        if (filled($this->input('website'))) {
            throw ValidationException::withMessages([
                'message' => 'Your submission could not be processed.',
            ]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function validatedData(): array
    {
        return $this->safe()->only(['name', 'email', 'subject', 'message']);
    }
}
