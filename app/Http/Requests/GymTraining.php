<?php

namespace App\Http\Requests;

use App\Game\Actions\Gym\Gym;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GymTraining extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $workouts = Gym::pluck(
            (new Gym)->getKeyName()
        )->toArray();

        return [
            'workout' => ['required', Rule::in($workouts)],
        ];
    }

    public function messages()
    {
        return [
            'workout.required' => 'You must select a workout',
        ];
    }
}
