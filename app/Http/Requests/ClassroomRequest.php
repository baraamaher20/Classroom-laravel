<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ClassroomRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'cover_image' => [
                'nullable',
                'image',
                // 'max:1024',
                //Rule::dimensions([
                    //'width' => 444,
                   // 'height' => 110,
               // ],
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute Important!',
            'name.required' => 'The Name is required!',
            'cover_image.dimensions' => 'Image dimensions must be 444 x 111',
        ];
    }
}
