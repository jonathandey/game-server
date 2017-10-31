<?php

namespace App\Http\Requests;

use App\Location;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class Travel extends FormRequest
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
        $playerLocation = (string) $this->user()->location->getKey();
        
        $locations = Location::where(
                (new Location)->getKeyName(), '!=', $playerLocation
            )
            ->pluck(
                (new Location)->getKeyName()
            )->toArray()
        ;

        return [
            'destination' => [
                'required', 
                Rule::in($locations),
            ],
        ];
    }

    public function messages()
    {
        return [
            'destination.different' => 'You are already at that location. Choose somewhere else.',
        ];
    }
}
