<?php

namespace App\Http\Requests\SensorData;

use Illuminate\Foundation\Http\FormRequest;

class StoreSensorDataRequest extends FormRequest
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
            'soil_moisture' => 'nullable|numeric|min:0|max:100',
            'temperature' => 'nullable|numeric|min:-50|max:80',
            'air_humidity' => 'nullable|numeric|min:0|max:100',
            'light_intensity' => 'nullable|numeric|min:0|max:100000',
            'ph_level' => 'nullable|numeric|min:0|max:14',
            'recorded_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'soil_moisture.min' => 'Soil moisture cannot be negative',
            'soil_moisture.max' => 'Soil moisture cannot exceed 100%',
            'temperature.min' => 'Temperature cannot be below -50°C',
            'temperature.max' => 'Temperature cannot exceed 80°C',
            'air_humidity.min' => 'Air humidity cannot be negative',
            'air_humidity.max' => 'Air humidity cannot exceed 100%',
            'light_intensity.min' => 'Light intensity cannot be negative',
            'ph_level.min' => 'pH level cannot be below 0',
            'ph_level.max' => 'pH level cannot exceed 14',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('recorded_at')) {
            $this->merge([
                'recorded_at' => now()
            ]);
        }
    }
}
