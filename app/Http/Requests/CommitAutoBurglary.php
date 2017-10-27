<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Game\Actions\Crimes\AutoBurglary;
use Illuminate\Foundation\Http\FormRequest;

class CommitAutoBurglary extends FormRequest
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
        $autoBurglaries = AutoBurglary::pluck(
            (new AutoBurglary)->getKeyName()
        )->toArray();

        return [
            'autoBurglary' => ['required', Rule::in($autoBurglaries)],
        ];
    }

    public function messages()
    {
        return [
            'autoBurglary.required' => 'You need to choose where to steal from',
        ];
    }
}
