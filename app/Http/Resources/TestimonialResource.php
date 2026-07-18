<?php

namespace App\Http\Resources;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Testimonial */
class TestimonialResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'position' => $this->position,
            'company' => $this->company,
            'quote' => $this->quote,
            'avatar_url' => $this->avatar_url,
            'sort_order' => $this->sort_order,
        ];
    }
}
