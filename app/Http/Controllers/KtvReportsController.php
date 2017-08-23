<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use Datatables;
use App\Models\Ktv;
use Illuminate\Http\Request;
use App\Models\ImportedDataUsage;
use App\Transformers\KtvReportTransformer;
use App\Contracts\Repositories\KtvReportRepository;

class KtvReportsController extends Controller
{
    protected $ktvReportRepository;

    public function __construct(KtvReportRepository $ktvReportRepository)
    {
        $this->ktvReportRepository = $ktvReportRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = \App\Models\Province::all();

        return view('ktvreports.index', compact('provinces'));
    }

    public function fee()
    {
        $provinces = \App\Models\Province::all();

        return view('ktvreports.fee', compact('provinces'));
    }

    public function show($id)
    {
        $ktv = \App\Models\Ktv::findOrFail($id);

        return view('ktvreports.show', compact('ktv'));
    }

    public function store(Request $request)
    {
        if ($request->ktv_id) {
            $ktv = \App\Models\Ktv::findOrFail($request->ktv_id);

            $ktv->fee_status = 'yes';
            $ktv->save();

            return response()->json(['status' => true, 'msg' => "Success"], 200);
        }
    }

    public function exportExcel()
    {
//        $ktv_reports = \App\Models\ImportedDataUsage::join('ktvs', 'imported_data_usages.ktv_id', '=', 'ktvs.id')
//            ->groupBy('ktv_id')
//            ->select(DB::raw('sum(imported_data_usages.times) as total_times, imported_data_usages.id, imported_data_usages.ktv_id, ktvs.name as ktv_name, ktvs.province_id, ktvs.district_id, ktvs.phone'));
        $config = json_decode(\App\Models\Config::orderBy('updated_at', 'desc')->first()->config, true);
        $ktv_reports = ImportedDataUsage::join('ktvs', 'imported_data_usages.ktv_id', '=', 'ktvs.id')
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

        if (request()->has('date')) {
            $date = explode(":", request('date'));
            $ktv_reports->whereBetween('imported_data_usages.date', [trim($date[0], ' '), trim($date[1], ' ')]);
        } else {
            $ktv_reports->whereBetween('imported_data_usages.date', [\Carbon\Carbon::now()->format('Y-m-01'), \Carbon\Carbon::now()->format('Y-m-31')]);
        }

        $ktv_reports = $ktv_reports->get();

        Excel::create('ktv_report', function ($excel) use($ktv_reports) {
            $excel->setTitle('Thống kê sử dụng bài hát của các đơn vị kinh doanh');
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
        return $this->ktvReportRepository->getDatatables($request);
    }

    public function detailDatatables(Request $request)
    {
        return $this->ktvReportRepository->getDetailDatatables($request);
    }

    public function boxesDetailDatatables(Ktv $ktv, Request $request)
    {
        return $this->ktvReportRepository->getBoxesDetailDatatables($ktv, $request);
    }
}
