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
            'price' => 'nullable',
            'user_id' => 'integer|nullable',
            'is_global' => 'nullable|boolean',
            'trainingDays' => 'required|numeric|min:1',
            'rows' => 'required|array',
            'rows.*' => 'array',
            'rows.*.*.exercise_name' => 'required|string',
            'rows.*.*.sets' => 'required|numeric',
            'rows.*.*.reps' => 'required|numeric',
            'rows.*.*.rir' => 'required|numeric',
            'rows.*.*.tempo' => 'required|string',
            'rows.*.*.break' => 'required|string',
        ];
    }
}
