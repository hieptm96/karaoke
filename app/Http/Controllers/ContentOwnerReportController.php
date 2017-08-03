<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use Debugbar;
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

    public function exportExcel()
    {
        $startDate = null;
        $stopDate = null;
        if ($request->has('date')) {
            $date = $request->date;
            $dates = explode(':', $date, 2);
            $startDate = $dates[0];
            $stopDate = $dates[1];
        } else {
            $startDate = (new Carbon('first day of this month'))
                            ->toDateString();
            $stopDate = (new Carbon('last day of this month'))
                            ->toDateString();
        }

        $query =
            DB::table('content_owners')
            ->selectRaw('id, name, SUM(money) total_money, phone, province_id, district_id')
            ->join(DB::raw('(
                select content_owner_id, t.song_file_name,
                    SUM(times) * percentage / 100 AS money, SUM(times), percentage
                    FROM
                    (select content_owner_id, song_id, song_file_name,
                    SUM(percentage) AS percentage
                    FROM content_owner_song c
                    GROUP BY content_owner_id, song_id) AS t
                    JOIN imported_data_usages i
                    ON t.song_file_name = i.song_file_name
                    WHERE date between ? and ?
                    GROUP BY i.song_file_name, content_owner_id
                    ORDER BY content_owner_id, song_file_name
                ) AS t2'
            ), 'id', '=', 't2.content_owner_id')
            ->groupBy('id')
            ->setBindings([$startDate, $stopDate]);

        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
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

        Excel::create('ktv_report', function ($excel) use($ktv_reports) {
            $excel->setTitle('Báo cáo tiền của các đơn vị sở hữu nội dung');
            $excel->sheet('Sheet 1',function ($sheet) use ($ktv_reports) {
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Times New Roman',
                        'size' => 12
                    )
                ));

//                $sheet->fromArray($ktv_reports);
                $sheet->loadView('content_owner_report.export',
                                    ['contentOwnerReports' => $contentOwnerReports]);
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

    public function show(Request $request, $id)
    {
        return view('content_owner_report.show', ['id' => $id]);
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
    public function detailDatatables(Request $request, $id)
    {
        return $this->contentOwnerReportRepository->getDetailDatatables($request, $id);
    }
}
