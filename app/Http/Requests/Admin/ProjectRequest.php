<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
        $projectId = $this->route('project')?->id;
        $required = $this->isMethod('POST') ? 'required' : 'sometimes';

        return [
            'title' => [$required, 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:180', Rule::unique('projects', 'slug')->ignore($projectId)],
            'tagline' => [$required, 'string', 'max:200'],
            'category' => ['nullable', 'string', 'max:80'],
            'role' => ['nullable', 'string', 'max:120'],
            'client' => ['nullable', 'string', 'max:120'],
            'year' => ['nullable', 'integer', 'min:2000', 'max:'.(date('Y') + 1)],
            'summary' => [$required, 'string', 'max:1000'],
            'problem' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'outcome' => ['nullable', 'string'],
            'highlights' => ['nullable', 'array'],
            'highlights.*' => ['string', 'max:300'],
            'metrics' => ['nullable', 'array'],
            'metrics.*.label' => ['required_with:metrics', 'string', 'max:80'],
            'metrics.*.value' => ['required_with:metrics', 'string', 'max:80'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'live_url' => ['nullable', 'url', 'max:255'],
            'repo_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'skill_ids' => ['nullable', 'array'],
            'skill_ids.*' => ['integer', 'exists:skills,id'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function attributesData(): array
    {
        return $this->safe()->except(['skill_ids']);
    }

    /**
     * @return array<int, int>|null
     */
    public function skillIds(): ?array
    {
        if (! $this->has('skill_ids')) {
            return null;
        }

        return array_map('intval', (array) $this->input('skill_ids', []));
    }
}
