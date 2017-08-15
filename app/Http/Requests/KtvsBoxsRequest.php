<?php

namespace App\Http\Requests;

use DB;
use App\Models\Ktv;
use App\Models\Box;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class KtvsBoxsRequest extends Request
{
    /**
     * KtvsBoxsRequest constructor.
     * @param ValidationFactory $validationFactory
     */
    public function __construct(ValidationFactory $validationFactory)
    {

        $validationFactory->extend(
            'uniqueCode',
            function ($attribute, $value, $parameters) {

                $count = Box::where('id', '<>', $this->box_id)
                            ->where('code', '=', $value)
                            ->count();

                return $count == 0;
            },
            'Mã bị trùng'
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
            'code' => "required|uniqueCode",
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã không được trống',
        ];
    }
}
