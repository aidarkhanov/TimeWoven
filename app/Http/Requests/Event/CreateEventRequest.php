<?php

namespace App\Http\Requests\Event;

use Illuminate\Validation\Rule;

class CreateEventRequest extends BaseEventRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        $rules = $this->baseRules();

        $rules['title'][] = 'required';
        $rules['description'][] = 'required';
        $rules['start_time'][] = 'required';

        return $rules;
    }
}
