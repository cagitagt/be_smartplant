<?php

namespace App\Http\Requests\Plant;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'planted_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'optimal_moisture_min' => 'nullable|integer|min:0|max:100',
            'optimal_moisture_max' => 'nullable|integer|min:0|max:100|gte:optimal_moisture_min',
            'optimal_temperature_min' => 'nullable|integer',
            'optimal_temperature_max' => 'nullable|integer|gte:optimal_temperature_min',
        ];
    }
}
