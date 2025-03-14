<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'category_id'  => 'required|integer',
            'title'        => 'required|string',
            'keywords'     => 'nullable|string',
            'content'      => 'required|string',
            'images'       => 'nullable|array',
            'images.*'     => 'mimes:jpeg,jpg,png,webp,svg',
        ];
    }
}
