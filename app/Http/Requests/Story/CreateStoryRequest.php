<?php

namespace App\Http\Requests\Story;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;


class CreateStoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string',
            'location'      => 'required|string',
            'date'          => 'required|date',
            'content'       => 'required|string',
            'images'        => 'required|array',
            'images.*'      => 'mimes:jpeg,jpg,png,webp,svg',
        ];
    }
}
