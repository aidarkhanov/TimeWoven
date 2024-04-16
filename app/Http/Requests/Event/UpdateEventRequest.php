<?php

namespace App\Http\Requests\Event;

use Illuminate\Validation\Rule;

class UpdateEventRequest extends BaseEventRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        $rules = $this->baseRules();

        foreach ($rules as $key => $value) {
            array_unshift($rules[$key], 'nullable');
        }

        return $rules;
    }
}
