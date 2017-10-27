<?php

namespace App\Http\Requests;

use App\Game\Game;
use App\StolenVehicle;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ManageVehicles extends FormRequest
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
        $vehicles = app(Game::class)
            ->player()
            ->vehicles()
            ->pluck(
                (new StolenVehicle)->getKeyName()
            )
            ->toArray()
        ;

        return [
            'selected.*' => [Rule::in($vehicles)],
        ];
    }

    public function messages()
    {
        return [
            'selected.*.in' => 'Invalid selection',
        ];
    }
}
