<?php

namespace App\Http\Requests\IrrigationSchedule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIrrigationScheduleRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'schedule_time' => 'sometimes|required|date_format:H:i',
            'duration_minutes' => 'sometimes|required|integer|min:1|max:1440',
            'repeat_days' => 'sometimes|required|array|min:1',
            'repeat_days.*' => 'integer|min:0|max:6',
            'is_active' => 'boolean',
            'auto_mode' => 'boolean',
            'moisture_threshold' => 'nullable|integer|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'schedule_time.date_format' => 'Schedule time must be in HH:MM format',
            'duration_minutes.min' => 'Duration must be at least 1 minute',
            'duration_minutes.max' => 'Duration cannot exceed 24 hours (1440 minutes)',
            'repeat_days.required' => 'At least one day must be selected',
            'repeat_days.*.min' => 'Day value must be between 0 (Sunday) and 6 (Saturday)',
            'repeat_days.*.max' => 'Day value must be between 0 (Sunday) and 6 (Saturday)',
            'moisture_threshold.min' => 'Moisture threshold cannot be negative',
            'moisture_threshold.max' => 'Moisture threshold cannot exceed 100%',
        ];
    }
}
