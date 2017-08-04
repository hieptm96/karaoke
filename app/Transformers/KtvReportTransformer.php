<?php

namespace App\Transformers;

use App\Models\ImportedDataUsage;
use League\Fractal\TransformerAbstract;

class KtvReportTransformer extends TransformerAbstract
{
    public function transform(ImportedDataUsage $import_data)
    {
         return [
             'id' => $import_data->id,
             // 'song_name' => $this->getSong($import_data->song_file_name),
             'ktv' => $import_data->ktv_name,
             'province' => $this->getProvince($import_data->province_id),
             'district' => $this->getDistrict($import_data->district_id),
             'phone' => $import_data->phone,
             'times' => $import_data->total_times,
             'total_money' => $this->getTotalMoney($import_data->total_times),
             'fee_status' => $this->getFeeStatus($import_data->fee_status),
             'fee_actions' => $this->getFeeAction($import_data->fee_status, $import_data->ktv_id),
             'actions' => '<a href="' . route('ktvreports.show', ['id' => $import_data->ktv_id]) . '" class="btn btn-xs btn-primary waves-effect waves-light ktv-detail"><i class="fa fa-edit"></i> Chi tiết</a>'
         ];
    }

    protected function getProvince($id)
    {
        $province = \App\Models\Province::where('id', $id)->first();
        return $province->name;
    }

    protected function getDistrict($id)
    {
        $district = \App\Models\District::where('id', $id)->first();
        return $district->name;
    }

    protected function getSong($song_file_name)
    {
        $song = \App\Models\Song::where('file_name', $song_file_name)->first();
        return $song->name;
    }

    protected function getTotalMoney($total_times)
    {
        $config = json_decode(\App\Models\Config::orderBy('updated_at')->first()->config, true);
        return number_format($total_times * intval($config['price']), 0, '.', '.') . ' VNĐ';
    }

    protected function getFeeStatus($status)
    {
        return ($status == 'no') ?
            '<span class="label label-danger">Chưa đóng tiền</span>' : '<span class="label label-success">Đã đóng tiền</span>';
    }

    protected function getFeeAction($status, $id)
    {
        return ($status == 'no') ? '<a href="#" data-id="' . $id . '" class="btn btn-xs btn-default waves-effect waves-light ktv-fee-confirm"><i class="fa fa-edit"></i> Xác nhận</a>' : '';
    }

}
