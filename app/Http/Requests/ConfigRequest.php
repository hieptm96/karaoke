<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
            'price' => 'required',
            'singer_rate' => 'required',
            'musician_rate' => 'required',
            'title_rate' => 'required',
            'film_rate' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'price.required' => 'Giá không được bỏ trống',
            'singer_rate.required' => 'Ca sỹ (%) không được bỏ trống',
            'musician_rate.required' => 'Tác giả (%) không được bỏ trống',
            'title_rate.required' => 'Lời (%) không được bỏ trống',
            'film_rate.required' => 'Quay phim(%) không được bỏ trống'
        ];
    }
}
