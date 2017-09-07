<?php

namespace App\Http\Requests;
use Illuminate\Validation\Factory as ValidationFactory;

class SongRequest extends Request
{
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'valid_language',
            function ($attribute, $value, $parameters) {
                $languageIndex = (int)$value;

                return array_key_exists($languageIndex, config('ktv.languages'));
            }
        );

        $validationFactory->extend(
            'valid_sum_percentages',
            function ($attribute, $percentages, $parameters) {

                $sumPercentages = array_sum($percentages);

                return $sumPercentages <= 100;
            }
        );

        $validationFactory->extend(
            'check_negative_percentage',
            function ($attribute, $percentages, $parameters) {

                foreach ($percentages as $percentage) {
                    if ($percentage < 0) {
                        return false;
                    }
                }

                return true;
            },
            'Phần trăm không được âm'
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
            'language' => 'required|valid_language',
            'authorPercentages' => 'valid_sum_percentages',
            'authorPercentages' => 'valid_sum_percentages|check_negative_percentage',
            'recordPercentages' => 'valid_sum_percentages|check_negative_percentage',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống',
            'language.required' => 'Phải chọn ngôn ngữ',
            'language.valid_language' => 'Ngôn ngữ không xác định',
            'authorPercentages.valid_sum_percentages' => 'Tổng phần trăm của quyền sở hữu tác giả không được vượt quá 100!',
            'recordPercentages.valid_sum_percentages' => 'Tổng phần trăm của quyền sở hữu bản ghi không được vượt quá 100!',
        ];
    }
}
