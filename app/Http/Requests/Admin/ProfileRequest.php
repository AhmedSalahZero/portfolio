<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:120'],
            'title' => ['sometimes', 'string', 'max:160'],
            'headline' => ['sometimes', 'string', 'max:255'],
            'bio' => ['sometimes', 'string'],
            'location' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:60'],
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:80'],
            'availability' => ['nullable', 'string', 'max:120'],
            'avatar_path' => ['nullable', 'string', 'max:255'],
            'cv_path' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'stats' => ['nullable', 'array'],
            'stats.*.label' => ['required_with:stats', 'string', 'max:80'],
            'stats.*.value' => ['required_with:stats', 'string', 'max:80'],
        ];
    }
}
