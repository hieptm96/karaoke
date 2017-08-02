<?php

namespace App\Repositories;

use DB;
use Datatables;
use Illuminate\Http\Request;
use App\Transformers\KtvReportTransformer;
use App\Contracts\Repositories\KtvReportRepository as Contract;

class KtvReportRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        // $ktv_report = \App\Models\ImportedDataUsage::join('ktvs', 'imported_data_usages.ktv_id', '=', 'ktvs.id')->select(DB::raw('sum(imported_data_usages.times) as total_times, imported_data_usages.id, imported_data_usages.ktv_id, ktvs.province_id, ktvs.district_id, ktvs.phone'))->groupBy('ktv_id')->get();
        $ktv_report = \App\Models\ImportedDataUsage::join('ktvs', 'imported_data_usages.ktv_id', '=', 'ktvs.id')
            ->groupBy('ktv_id')
            ->select(DB::raw('sum(imported_data_usages.times) as total_times, imported_data_usages.id, imported_data_usages.ktv_id, ktvs.name as ktv_name, ktvs.province_id, ktvs.district_id, ktvs.phone'));

        return Datatables::of($ktv_report)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                     $param = '%'.$request->name.'%';
                     $query->where('name', 'like', $param);
                 }
                 if ($request->has('phone')) {
                     $query->where('phone', 'like', '%'.$request->phone.'%');
                 }
                 if ($request->has('province')) {
                     $query->where('province_id', $request->province);
                 }

                 if ($request->has('district')) {
                     $query->where('district_id', $request->district);
                 }
            })
            ->addColumn('actions', function ($song) {
                return $this->generateActionColumn($song);
            })
            ->setTransformer(new KtvReportTransformer)
            ->make(true);
    }

    protected function getActionColumnPermissions($song)
    {
        return [
            //
        ];
    }
}