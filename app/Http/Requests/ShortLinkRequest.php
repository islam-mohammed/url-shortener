<?php

namespace App\Http\Requests;

use App\Models\ShortLink;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'destination' => ['required', 'url', 'max:255', Rule::unique(ShortLink::class)->ignore($this->user()->id)],
            'slug' => ['required', 'string', 'min:5', 'max:5'],
            'user_id' => ['required']
        ];
    }
}
