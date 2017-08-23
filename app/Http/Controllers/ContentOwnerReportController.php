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
            ->selectRaw('co.id AS id, co.name AS name, SUM(money) * ? AS total_money,
             phone, p.name AS province, d.name AS district, has_fee')
            ->join(DB::raw('(
            	select content_owner_id, t.song_file_name,
                	SUM(times) * percentage / 100 AS money, SUM(times), percentage
                	FROM
                	(select content_owner_id, song_file_name,
                	SUM(percentage) AS percentage
                	FROM content_owner_song c
                	GROUP BY content_owner_id, song_file_name) AS t
                	JOIN imported_data_usages i
                	ON t.song_file_name = i.song_file_name
                    WHERE date between ? and ?
                	GROUP BY i.song_file_name, content_owner_id
                	ORDER BY content_owner_id, song_file_name
                ) AS t2'
            ), 'id', '=', 't2.content_owner_id')
            ->join('songs AS s', function($join) {
                $join->on('t2.song_file_name', '=', 's.file_name');
                $join->on('s.has_fee', '<>', DB::raw('?'));
            })
            ->join('provinces AS p', 'co.province_id', '=', 'p.id')
            ->join('districts AS d', 'co.district_id', '=', 'd.id')
            ->groupBy('co.id')
            ->setBindings([intval($config['price']), $startDate, $stopDate, 0]);

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
