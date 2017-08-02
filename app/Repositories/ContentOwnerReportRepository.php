<?php

namespace App\Repositories;

use DB;
use Datatables;
use Carbon\Carbon;
use App\Models\ContentOwner;
use Illuminate\Http\Request;
use App\Transformers\ContentOwnerReportTransformer;
use App\Contracts\Repositories\ContentOwnerReportRepository as Contract;

class ContentOwnerReportRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
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

        // ngu nguoi
        // $contentOwnerReport = DB::select('select co.id, co.name, sum(money) total_money,
        //                 phone, province_id, district_id
        //                 from (
        //                 	select content_owner_id, t.song_file_name,
        //                 	sum(times) * percentage / 100 as money, sum(times), percentage
        //                 	from
        //                 	(select content_owner_id, song_id, song_file_name,
        //                 	sum(percentage) as percentage
        //                 	from content_owner_song c
        //                 	group by content_owner_id, song_id) as t
        //                 	join imported_data_usages i
        //                 	on t.song_file_name = i.song_file_name
        //                 	group by i.song_file_name, content_owner_id
        //                 	order by content_owner_id, song_file_name
        //                 ) t2
        //                 join content_owners co
        //                 on t2.content_owner_id = co.id
        //                 group by co.id;');

        // ngu tap 2
        $contentOwnerReport =
            DB::table('content_owners')
            ->selectRaw('id, name, sum(money) total_money, phone, province_id, district_id')
            ->join(DB::raw('(
            	select content_owner_id, t.song_file_name,
                	sum(times) * percentage / 100 as money, sum(times), percentage
                	from
                	(select content_owner_id, song_id, song_file_name,
                	sum(percentage) as percentage
                	from content_owner_song c
                	group by content_owner_id, song_id) as t
                	join imported_data_usages i
                	on t.song_file_name = i.song_file_name
                    where date between ? and ?
                	group by i.song_file_name, content_owner_id
                	order by content_owner_id, song_file_name
                ) as t2'
            ), 'id', '=', 't2.content_owner_id')
            ->groupBy('id')
            ->setBindings([$startDate, $stopDate]);

        // dd($contentOwnerReport);

        return Datatables::of($contentOwnerReport)
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
            ->addColumn('actions', function ($contentOwnerReport) {
                return $this->generateActionColumn($contentOwnerReport);
            })
            ->setTransformer(new ContentOwnerReportTransformer)
            ->make(true);
    }

    protected function getActionColumnPermissions($song)
    {
        return [
            //
        ];
    }
}
