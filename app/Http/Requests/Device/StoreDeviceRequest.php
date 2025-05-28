<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
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
            'device_name' => 'required|string|max:255',
            'device_type' => 'required|in:sensor,pump,valve,controller,camera,other',
            'device_id' => 'required|string|max:100|unique:devices,device_id',
            'status' => 'required|in:online,offline,maintenance,error',
            'battery_level' => 'nullable|integer|min:0|max:100',
            'firmware_version' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'device_type.in' => 'Device type must be one of: sensor, pump, valve, controller, camera, other',
            'device_id.unique' => 'Device ID already exists in the system',
            'status.in' => 'Status must be one of: online, offline, maintenance, error',
            'battery_level.min' => 'Battery level cannot be negative',
            'battery_level.max' => 'Battery level cannot exceed 100%',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'last_connected' => now()
        ]);
    }
}
