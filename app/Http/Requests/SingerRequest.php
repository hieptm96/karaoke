<?php

namespace App\Http\Requests;
use Illuminate\Validation\Factory as ValidationFactory;

class SingerRequest extends Request
{
    public function __construct(ValidationFactory $validationFactory)
    {

        $validationFactory->extend(
            'validSex',
            function ($attribute, $value, $parameters) {
                $sexIndex = (int)$value;

                return array_key_exists($sexIndex, config('ktv.sexes'));
            },
            'Sorry, it failed foo validation!'
        );

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
            'sex' => 'required|validSex',
            'language' => 'required|validLanguage',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống',
            'sex.required' => 'Phải chọn giới tính',
            'language.required' => 'Phải chọn ngôn ngữ'
        ];
    }
}
