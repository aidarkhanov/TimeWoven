<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function baseRules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'description' => ['string'],
            'start_time' => ['date'],
            'end_time' => ['date', 'after:start_time'],
            'external_link' => ['url'],
            'organiser_email' => ['email'],
            'gallery' => ['array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
