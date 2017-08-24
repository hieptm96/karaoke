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
            ->selectRaw('s.id, file_name, name, has_fee, sum(times) as total_times,
                            sum(CASE WHEN has_fee <> 0 THEN times ELSE 0 END) AS total_money')
            ->join('imported_data_usages as i', 'i.song_id', '=' , 's.id')
            ->whereNull('s.deleted_at')
            ->whereBetween('i.date', ['?', '?'])
            ->groupBy('s.id')
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
    public function detailDatatables(Song $song, Request $request)
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

        $query = DB::table('ktvs AS k')
            ->selectRaw('k.id, k.name, k.phone, p.name AS province, d.name AS district, sum(times) as total_times')
            ->join('imported_data_usages as i', 'k.id', '=' , 'i.ktv_id')
            ->join('provinces AS p', 'k.province_id', '=', 'p.id')
            ->join('districts AS d', 'k.district_id', '=', 'd.id')
            ->where('i.song_id', '=', '?')
            ->whereNull('k.deleted_at')
            ->whereBetween('i.date', ['?', '?'])
            ->groupBy('k.id')
            ->setBindings([$song->id, $startDate, $stopDate]);

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
