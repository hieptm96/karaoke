<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use Debugbar;
use Datatables;
use Carbon\Carbon;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Transformers\SongReportTransformer;
use App\Transformers\SongDetailReportTransformer;
use App\Contracts\Repositories\ContentOwnerReportRepository;

class SongReportController extends Controller
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
        return view('song_reports.index');
    }


    public function show(Request $request, $id)
    {
        $provinces = \App\Models\Province::all();
        $song = Song::findOrFail($id);

        return view('song_reports.show', ['song' => $song, 'provinces' => $provinces]);
    }

    /*
     * API for datatable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mix
     */
    public function datatables(Request $request)
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

        $query = DB::table('songs AS s')
                    ->selectRaw('id, file_name, name, has_fee, total_times,
                            (CASE WHEN has_fee <> 0 THEN total_times ELSE 0 END) AS total_money')
                    ->join(DB::raw('(SELECT  song_file_name, sum(times) AS total_times
                            	FROM imported_data_usages i
                                WHERE date BETWEEN ? AND ?
                            	GROUP BY song_file_name) AS t'
                    ), 's.file_name', '=' , 't.song_file_name')
                    ->setBindings([$startDate, $stopDate]);
                    // ->get();
        // dd($query);
        return Datatables::of($query)
            ->filter(function ($query) use ($request) {
                 if ($request->has('name')) {
                     $param = '%'.$request->name.'%';
                    $query->where('name', 'like', $param);
                 }
                 if ($request->has('file_name')) {
                     $query->where('file_name', 'like', '%'.$request->file_name.'%');
                 }
            })
            ->setTransformer(new SongReportTransformer)
            ->make(true);

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
        if ($request->has('date')) {
            $dates = explode(':', $request->date, 2);
            $startDate = $dates[0];
            $stopDate = $dates[1];
        } else {
            $startDate = $request->from;
            $stopDate = $request->to;

            if (empty($startDate) || empty($stopDate)) {
                $startDate = (new Carbon('first day of this month'))->format('Y-m-d');
                $stopDate = (new Carbon('last day of this month'))->format('Y-m-d');
            }
        }

//        $song = Song::where('id', '=', $request->id)->findOrFail();

        $fileName = $request->filename;

        $query = DB::table('ktvs AS k')
                    ->selectRaw('k.id, k.name, k.phone, p.name AS province, d.name AS district, total_times')
                    ->join(DB::raw('(select  ktv_id, sum(times) as total_times
                                	from imported_data_usages i
                                	where song_file_name = ?
                                    AND date BETWEEN ? AND ?
                                	group by ktv_id) AS t'
                    ), 'k.id', '=' , 't.ktv_id')
                    ->join('provinces AS p', 'k.province_id', '=', 'p.id')
                    ->join('districts AS d', 'k.district_id', '=', 'd.id')
                    ->setBindings([$fileName, $startDate, $stopDate]);

        return Datatables::of($query)
            ->filter(function ($query) use ($request) {
                 if ($request->has('name')) {
                     $param = '%'.$request->name.'%';
                     $query->where('k.name', 'like', $param);
                 }
                 if ($request->has('phone')) {
                     $query->where('k.phone', 'like', '%'.$request->phone.'%');
                 }
                 if ($request->has('province')) {
                     $query->where('k.province_id', '=', $request->province);
                 }

                 if ($request->has('district')) {
                     $query->where('k.district_id', $request->district);
                 }
            })
            ->setTransformer(new SongDetailReportTransformer)
            ->make(true);

        return $this->contentOwnerReportRepository->getDetailDatatables($request);
    }
}
