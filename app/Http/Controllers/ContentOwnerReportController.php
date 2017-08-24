<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Transformers\ContentOwnerReportTransformer;
use App\Transformers\ContentOwnerDetailReportTransformer;
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

    public function exportExcel(Request $request)
    {
        $startDate = null;
        $stopDate = null;
        if ($request->has('date')) {
            $dates = explode(':', $request->date, 2);
            $startDate = $dates[0];
            $stopDate = $dates[1];
        } else {
            $startDate = (new Carbon('first day of this month'))->format('Y-m-d');
            $stopDate = (new Carbon('last day of this month'))->format('Y-m-d');
        }

        $config = json_decode(\App\Models\Config::orderBy('updated_at', 'desc')->first()->config, true);


        $query =
            DB::table('content_owners as co')
            ->selectRaw('co.id AS id, co.name AS name, SUM(? * times * percentage / 100) as total_money, phone, p.name AS province, d.name AS district, has_fee')
            ->join('content_owner_song as cos', 'cos.content_owner_id', '=', 'co.id')
            ->join('songs AS s', function($join) {
                $join->on('cos.song_id', '=', 's.id');
                $join->on('s.has_fee', '<>', DB::raw('?'));
            })
            ->join('imported_data_usages as i', 'i.song_id', '=', 'cos.song_id')
            ->join('provinces AS p', 'co.province_id', '=', 'p.id')
            ->join('districts AS d', 'co.district_id', '=', 'd.id')
            ->whereNull('co.deleted_at')
            ->whereNull('s.deleted_at')
            ->whereBetween('i.date', ['?', '?'])
            ->groupBy('co.id')
            ->setBindings([intval($config['price']), 0, $startDate, $stopDate]);

        if ($request->has('name')) {
            $query->where('co.name', 'like', '%'.$request->name.'%');
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

        $contentOwnerReports = $query->get();

        Excel::create('contentowner_report', function ($excel) use($contentOwnerReports) {
            $excel->setTitle('Báo cáo tiền của các đơn vị sở hữu nội dung');
            $excel->sheet('Sheet 1',function ($sheet) use ($contentOwnerReports) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Times New Roman',
                        'size' => 12
                    )
                ));

                $sheet->loadView('content_owner_report.export',
                                    ['content_owners' => $contentOwnerReports]);
            });
        })->store('xlsx', 'exports');
        return [
            'success' => true,
            'path' => 'http://'.request()->getHttpHost().'/exports/contentowner_report.xlsx'
        ];
    }

    public function getDistricts(Request $request)
    {
        $districts = \App\Models\District::where('province_id', $request->province_id)->get();

        return response()->json(['data' => $districts, 'msg' => "Success"], 200);
    }

    public function show(Request $request, $id)
    {
        $content_owner = \App\Models\ContentOwner::findOrFail($id);

        return view('content_owner_report.show', compact('content_owner'));
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

    /*
     * API for datatable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mix
     */
    public function detailDatatables(Request $request)
    {
        return $this->contentOwnerReportRepository->getDetailDatatables($request);
    }
}
