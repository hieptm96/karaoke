<?php

namespace App\Http\Requests;

class KtvRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống',
            'province_id.required' => 'Phải chọn tỉnh',
            'district_id.required' => 'Phải chọn quận/huyện'
        ];
    }
}
