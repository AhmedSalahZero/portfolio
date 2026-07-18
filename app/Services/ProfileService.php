<?php

namespace App\Services;

use App\Models\Profile;

class ProfileService
{
    public function current(): Profile
    {
        return Profile::current();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(array $attributes): Profile
    {
        $profile = Profile::query()->first();

        if ($profile) {
            $profile->fill($attributes)->save();

            return $profile->refresh();
        }

        return Profile::query()->create($attributes);
    }
}
