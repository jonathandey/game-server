<?php

namespace App\Http\Requests;

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
        return [
            'crime' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'crime.required' => 'You need to choose a crime to commit',
        ];
    }
}
