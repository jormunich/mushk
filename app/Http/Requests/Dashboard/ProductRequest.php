<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return  [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'old_price' => ['nullable', 'numeric'],
            'review_count' => ['nullable', 'numeric'],
            'review' => ['nullable', 'numeric'],
            'description' => ['required', 'string', 'max:5000'],
            'is_popular' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpg'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id']
        ];
    }
}
