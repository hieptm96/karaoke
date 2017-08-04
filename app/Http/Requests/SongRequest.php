<?php

namespace App\Http\Requests;
use Illuminate\Validation\Factory as ValidationFactory;

class SongRequest extends Request
{
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'validLanguage',
            function ($attribute, $value, $parameters) {
                $languageIndex = (int)$value;

                return array_key_exists($languageIndex, config('ktv.languages'));
            },
            'Sorry, it failed foo validation!'
        );
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
            'language' => 'required|validLanguage',
            'file_name' => 'required|unique:songs',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống',
            'language.required' => 'Phải chọn ngôn ngữ',
            'file_name.required' => 'Tên file không được trống',
            'file_name.unique' => 'Tên file bị trùng',
        ];
    }
}
