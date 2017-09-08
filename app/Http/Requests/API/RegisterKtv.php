<?php

namespace App\Http\Requests\API;

class RegisterKtv extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'm_type' => 'required',
            'ktv_id' => 'required',
            'box_id' => 'required',
        ];
    }
}
