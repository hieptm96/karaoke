<?php

namespace App\Http\Requests\API;

class DataUsage extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'partner' => 'required',
//            'mac' => 'required',
//            'data' => 'array|required',
//            'data.*.song_id' => 'required',
//            'data.*.times' => 'required',
            'ktv_id' => 'required',
            'box_id' => 'required',
            'song_id' => 'required',
        ];
    }
}
