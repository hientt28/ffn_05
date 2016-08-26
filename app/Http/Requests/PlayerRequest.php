<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlayerRequest extends Request
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
            'name' => 'required',
            'birthday' => 'required|date_format:d/m/Y',
            'position' => 'required|exists:positions',
            'country_id' => 'required|exists:countries',
            'team_id' => 'required|exists:teams',
        ];
    }
}
