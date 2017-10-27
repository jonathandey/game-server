<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFight extends FormRequest
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
            'monetary_stake' => 'required|min:100|numeric',
            'taunt' => 'max:40',
        ];
    }
}
