<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSoftwareRequest extends FormRequest
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
            'icon' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:software,slug',
            'short_description' => 'required|string|max:500',
            'rating' => 'nullable|numeric|min:0|max:5',
            'downloads_count' => 'required|integer|min:0',        
            'download_button_text' => 'nullable|string|max:100',
            'download_url' => 'required|url',
            'official_button_text' => 'nullable|string|max:100',
            'official_website' => 'nullable|url',
            'screenshots' => 'nullable|array|max:10',
            'screenshots.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'required|string|max:10000',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'icon.required' => 'Software icon is required.',
            'icon.image' => 'Icon must be an image.',
            'icon.mimes' => 'Icon must be JPG, PNG, WEBP or SVG.',
            'icon.max' => 'Icon size must not exceed 2MB.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category is invalid.',
            'subcategory_id.exists' => 'Selected subcategory is invalid.',
            'title.required' => 'Software title is required.',
            'slug.required' => 'Slug is required.',
            'slug.unique' => 'This slug already exists.',
            'short_description.required' => 'Short description is required.',
            'short_description.max' => 'Short description may not be greater than 500 characters.',
            'download_button_text.max' => 'Download button text may not be greater than 100 characters.',
            'download_url.required' => 'Download URL is required.',
            'download_url.url' => 'Please enter a valid download URL.',
            'official_button_text.max' => 'Official button text may not be greater than 100 characters.',
            'official_website.url' => 'Please enter a valid official website URL.',
            'screenshots.array' => 'Screenshots must be an array.',
            'screenshots.max' => 'Maximum 10 screenshots are allowed.',
            'screenshots.*.image' => 'Each screenshot must be an image.',
            'screenshots.*.mimes' => 'Screenshots must be JPG, PNG or WEBP.',
            'screenshots.*.max' => 'Each screenshot must not exceed 5MB.',
            'description.required' => 'Software description is required.',
            'description.max' => 'Description may not be greater than 10000 characters.',
        ];
    }
}