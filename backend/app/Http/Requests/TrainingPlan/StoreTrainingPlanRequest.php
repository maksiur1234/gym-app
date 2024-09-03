<?php

namespace App\Http\Requests\TrainingPlan;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingPlanRequest extends FormRequest
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
            'planName' => 'required|string',
            'planDesc' => 'nullable|string',
            'price' => 'nullable|numeric',
            'user_id' => 'nullable|numeric',
            'trainingDays' => 'required|numeric|min:1',
            'rows' => 'required|array',
            'rows.*' => 'array',
            'rows.*.*.name' => 'required|string',
            'rows.*.*.sets' => 'required|numeric',
            'rows.*.*.reps' => 'required|numeric',
            'rows.*.*.rir' => 'required|numeric',
            'rows.*.*.tempo' => 'required|string',
            'rows.*.*.break' => 'required|string',
        ];
    }
}
