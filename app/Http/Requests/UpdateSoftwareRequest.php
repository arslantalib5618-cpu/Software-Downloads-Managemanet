<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSoftwareRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',

            'title' => 'required|string|max:255',

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('software', 'slug')->ignore($this->route('software')->id),
            ],

            'short_description' => 'required|string|max:500',
            'rating' => 'nullable|numeric|min:0|max:5',
            'downloads_count' => 'nullable|string|max:1000000',

            'download_button_text' => 'nullable|string|max:100',
            'download_url' => 'required|url',

            'official_button_text' => 'nullable|string|max:100',
            'official_website' => 'nullable|url',

            'screenshots' => 'nullable|array|max:10',
            'screenshots.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',

            'description' => 'required|string|max:10000',
        ];
    }
     public function messages(): array
    {
        return (new StoreSoftwareRequest())->messages();
    }
}
