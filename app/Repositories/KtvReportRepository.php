<?php

namespace App\Repositories;

use DB;
use Datatables;
use App\Models\Ktv;
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
            // ->join('songs', 'imported_data_usages.song_file_name', '=', 'songs.file_name')
            ->join('songs', 'imported_data_usages.song_id', '=', 'songs.id')
            // ->where('songs.has_fee', 1)
            ->groupBy('ktv_id')
            ->select(DB::raw('sum(imported_data_usages.times) as total_times,
                    sum(case when songs.has_fee <> 0 then imported_data_usages.times else 0 end)  as fee_total_times
                    , imported_data_usages.id, imported_data_usages.ktv_id, ktvs.name as ktv_name, ktvs.fee_status as fee_status, ktvs.province_id, ktvs.district_id, ktvs.phone'));

        return Datatables::of($ktv_report)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                     $param = '%'.$request->name.'%';
                     $query->where('ktvs.name', 'like', $param);
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

                 if ($request->has('date')) {
                    $date = explode(":", $request->date);
                    $query->whereBetween('imported_data_usages.date', [trim($date[0], ' '), trim($date[1], ' ')]);
                 } else {
                     $query->whereBetween('imported_data_usages.date', [\Carbon\Carbon::now()->format('Y-m-01'), \Carbon\Carbon::now()->format('Y-m-31')]);
                 }
            })
            ->addColumn('actions', function ($song) {
                return $this->generateActionColumn($song);
            })
            ->setTransformer(new KtvReportTransformer)
            ->make(true);
    }

    public function getDetailDatatables(Request $request)
    {
        $ktv_reports = \App\Models\ImportedDataUsage::with(array('song'=>function($query){
                            // $query->select('file_name','name');
                            $query->select('id','name');
                        }))
                        ->where('ktv_id', $request->id)
                        // ->select('song_file_name','ktv_id', 'times', 'date');
                        ->select('song_id','ktv_id', 'times', 'date');


        return Datatables::of($ktv_reports)
            ->filter(function ($query) use ($request) {
                if ($request->has('from') && $request->has('to')) {
                    $query->whereBetween('imported_data_usages.date', [$request->from, $request->to]);
                } else {
                    $query->whereBetween('imported_data_usages.date', [\Carbon\Carbon::now()->format('Y-m-01'), \Carbon\Carbon::now()->format('Y-m-31')]);
                }
                if ($request->has('date')) {
                    $date = explode(":", $request->date);
                    $query->whereBetween('imported_data_usages.date', [trim($date[0], ' '), trim($date[1], ' ')]);
                }
            })
            ->editColumn('ktv_name', function($ktv_report) {
                return $ktv_report->ktv->name;
            })
            ->addColumn('action', function($ktv_report) {
                return ($ktv_report->song->has_fee == 1) ? '<span class="label label-success">Có phí</span>' : '<span class="label label-primary">Không có phí</span>';
            })
            ->make(true);
    }

    public function getBoxesDetailDatatables(Ktv $ktv, Request $request)
    {
        $ktvBoxesReports = DB::table('boxes as b')
                            ->selectRaw('box_code, sum(times) as sum_times, 
                            sum(case when s.has_fee <> 0 then i.times else 0 end)  as fee_times,
                            sum(case when s.has_fee = 0 then i.times else 0 end)  as no_fee_times')
                            ->leftJoin('imported_data_usages as i', function($join) {
                                $join->on('i.box_code', '=', 'b.code');
                            })
                            ->join('songs as s', 's.id', '=', 'i.song_id')
                            ->whereNull('b.deleted_at')
                            ->whereNull('s.deleted_at')
                            ->where('i.ktv_id', '=', '?')
                            ->groupBy('box_code')
                            ->setBindings([$ktv->id]);

        return Datatables::of($ktvBoxesReports)
            ->filter(function ($query) use ($request) {
                if ($request->has('from') && $request->has('to')) {
                    $query->whereBetween('i.date', [$request->from, $request->to]);
                } else {
                    $query->whereBetween('i.date', [\Carbon\Carbon::now()->format('Y-m-01'), \Carbon\Carbon::now()->format('Y-m-31')]);
                }
                if ($request->has('date')) {
                    $date = explode(":", $request->date);
                    $query->whereBetween('i.date', [trim($date[0], ' '), trim($date[1], ' ')]);
                }
            })
//            ->editColumn('ktv_name', function($ktv_report) {
//                return $ktv_report->ktv->name;
//            })
//            ->addColumn('action', function($ktv_report) {
//                return ($ktv_report->song->has_fee == 1) ? '<span class="label label-success">Có phí</span>' : '<span class="label label-primary">Không có phí</span>';
//            })
            ->make(true);
    }

    protected function getActionColumnPermissions($song)
    {
        return [
            //
        ];
    }
}
