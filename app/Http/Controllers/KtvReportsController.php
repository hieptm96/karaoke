<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
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
        return view('ktvreports.index');
    }

    public function exportExcel()
    {
        $ktv = \App\Models\Song::all();

        Excel::create('ktv_report', function ($excel) use($ktv) {
            $excel->setTitle('Ktv song report');
            $excel->sheet('Sheet 1',function ($sheet) use ($ktv) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Times New Roman',
                        'size' => 12
                    )
                ));

                $sheet->fromArray($ktv);
            });
        })->store('xlsx', 'exports');
        return [
            'success' => true,
            'path' => 'http://'.request()->getHttpHost().'/exports/ktv_report.xlsx'
        ];
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
}
