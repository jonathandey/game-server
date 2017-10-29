<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Game\Actions\Crimes\Crime;
use Illuminate\Foundation\Http\FormRequest;

class CommitCrime extends FormRequest
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
        $crimes = Crime::pluck(
            (new Crime)->getKeyName()
        )
        ->toArray();

        return [
            'crime' => ['required', Rule::in($crimes)],
        ];
    }

    public function messages()
    {
        return [
            'crime.required' => 'You need to choose a crime to commit',
        ];
    }
}
