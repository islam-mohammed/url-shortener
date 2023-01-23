<?php

namespace App\Http\Requests;

use App\Models\ShortLink;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Whoops\Run;

class ShortLinkRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
         return [
            'destination' => ['required', 'url', 'max:255', Rule::unique('short_links')->where(fn($query) => $query->where('user_id', $this->user_id)
                ->where('destination', $this->destination)
            )],
            'user_id' => ['required', 'exists:App\Models\User,id']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'destination.url' => 'Please enter a valid URL',
            'destination.required' => 'Please enter a valid URL',
            'destination.unique' => 'Please enter a unique URL',
            'user_id.required' => 'Please enter a user id',
            'user_id.exists' => 'The user id does not exist'
        ];
    }
}
