<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use Debugbar;
use Illuminate\Http\Request;
use App\Transformers\ContentOwnerReportTransformer;
use App\Contracts\Repositories\ContentOwnerReportRepository;

class ContentOwnerReportController extends Controller
{
    protected $contentOwnerReportRepository;

    public function __construct(ContentOwnerReportRepository $contentOwnerReportRepository)
    {
        $this->contentOwnerReportRepository = $contentOwnerReportRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = \App\Models\Province::all();

        return view('content_owner_report.index', compact('provinces'));
    }

    public function exportExcel()
    {
//        $ktv_reports = \App\Models\ImportedDataUsage::join('ktvs', 'imported_data_usages.ktv_id', '=', 'ktvs.id')
//            ->groupBy('ktv_id')
//            ->select(DB::raw('sum(imported_data_usages.times) as total_times, imported_data_usages.id, imported_data_usages.ktv_id, ktvs.name as ktv_name, ktvs.province_id, ktvs.district_id, ktvs.phone'));
        $config = json_decode(\App\Models\Config::orderBy('updated_at', 'desc')->first()->config, true);
        $ktv_reports = \App\Models\ImportedDataUsage::join('ktvs', 'imported_data_usages.ktv_id', '=', 'ktvs.id')
            ->join('provinces', 'ktvs.province_id', '=', 'provinces.id')
            ->join('districts', 'ktvs.district_id', '=', 'districts.id')
            ->groupBy('ktv_id')
            ->select(DB::raw('imported_data_usages.id, ktvs.name as ktv_name, provinces.name as province, districts.name as district, ktvs.phone, sum(imported_data_usages.times) as total_times, (sum(imported_data_usages.times) * ?) as total_money'))
            ->setBindings([intval($config['price'])]);

        if (request()->has('name')) {
            $ktv_reports->where('ktvs.name', 'like', '%' . request('name') . '%');
        }

        if(request()->has('phone')) {
            $ktv_reports->where('phone', 'like', '%' . request('phone') . '%');
        }

        if(request()->has('province')) {
            $ktv_reports->where('province_id', request('province'));
        }

        if(request()->has('district')) {
            $ktv_reports->where('district_id', request('district'));
        }

        $ktv_reports = $ktv_reports->get();

        Excel::create('ktv_report', function ($excel) use($ktv_reports) {
            $excel->setTitle('Ktv song report');
            $excel->sheet('Sheet 1',function ($sheet) use ($ktv_reports) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Times New Roman',
                        'size' => 12
                    )
                ));

//                $sheet->fromArray($ktv_reports);
                $sheet->loadView('ktvreports.export', ['ktv_reports' => $ktv_reports]);
            });
        })->store('xlsx', 'exports');
        return [
            'success' => true,
            'path' => 'http://'.request()->getHttpHost().'/exports/ktv_report.xlsx'
        ];
    }

    public function getDistricts(Request $request)
    {
        $districts = \App\Models\District::where('province_id', $request->province_id)->get();

        return response()->json(['data' => $districts, 'msg' => "Success"], 200);
    }

    /*
     * API for datatable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mix
     */
    public function datatables(Request $request)
    {
        return $this->contentOwnerReportRepository->getDatatables($request);
    }
}
