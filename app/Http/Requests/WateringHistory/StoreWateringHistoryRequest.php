<?php

namespace App\Http\Requests\WateringHistory;

use Illuminate\Foundation\Http\FormRequest;

class StoreWateringHistoryRequest extends FormRequest
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
            'watered_at' => 'nullable|date',
            'duration_minutes' => 'required|integer|min:1|max:1440',
            'water_amount_ml' => 'nullable|integer|min:1|max:10000',
            'method' => 'required|in:manual,automatic,scheduled,sensor_triggered',
            'moisture_before' => 'nullable|numeric|min:0|max:100',
            'moisture_after' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'duration_minutes.min' => 'Duration must be at least 1 minute',
            'duration_minutes.max' => 'Duration cannot exceed 24 hours (1440 minutes)',
            'water_amount_ml.min' => 'Water amount must be at least 1ml',
            'water_amount_ml.max' => 'Water amount cannot exceed 10 liters (10000ml)',
            'method.in' => 'Method must be one of: manual, automatic, scheduled, sensor_triggered',
            'moisture_before.min' => 'Moisture level cannot be negative',
            'moisture_before.max' => 'Moisture level cannot exceed 100%',
            'moisture_after.min' => 'Moisture level cannot be negative',
            'moisture_after.max' => 'Moisture level cannot exceed 100%',
            'notes.max' => 'Notes cannot exceed 500 characters',
        ];
    }
}
