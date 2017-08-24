<?php

namespace App\Repositories;

use DB;
use Datatables;
use Carbon\Carbon;
use App\Models\ContentOwner;
use Illuminate\Http\Request;
use App\Transformers\ContentOwnerReportTransformer;
use App\Transformers\ContentOwnerDetailReportTransformer;
use App\Contracts\Repositories\ContentOwnerReportRepository AS Contract;

class ContentOwnerReportRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
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

//        ->join(DB::raw('(
//            	select content_owner_id, t.song_file_name, t.song_id,
//                	SUM(times) * percentage / 100 AS money, SUM(times), percentage
//                	FROM
//                	(select content_owner_id, song_file_name,
//                	SUM(percentage) AS percentage
//                	FROM content_owner_song c
//                	GROUP BY content_owner_id, song_file_name) AS t
//                	JOIN imported_data_usages i
//                	ON t.song_file_name = i.song_file_name
//                    WHERE date between ? and ?
//                	GROUP BY i.song_file_name, content_owner_id
//                	ORDER BY content_owner_id, song_file_name
//                ) AS t2'
//    ), 'id', '=', 't2.content_owner_id')

        $contentOwnerReport =
            DB::table('content_owners as co')
            ->selectRaw('co.id AS id, co.name AS name, SUM(times) * percentage / 100 AS total_money, phone, province_id, district_id')
            ->join(DB::raw('(select content_owner_id, song_id,
                	SUM(percentage) AS percentage
                	FROM content_owner_song c
                	GROUP BY content_owner_id, song_file_name) AS t'
            ), 'co.id', '=', 't.content_owner_id')
            ->join('songs AS s', function($join) {
                $join->on('t.song_id', '=', 's.id');
                $join->on('s.has_fee', '<>', DB::raw('?'));
            })
            ->join('imported_data_usages as i', 'i.song_id', '=','s.id')
            ->whereBetween('i.date', ['?', '?'])
            ->groupBy('co.id')
            ->setBindings([0, $startDate, $stopDate]);


        return Datatables::of($contentOwnerReport)
            ->filter(function ($query) use ($request) {
                 if ($request->has('name')) {
                     $param = '%'.$request->name.'%';
                    $query->where('co.name', 'like', $param);
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

    public function getDetailDatatables(Request $request)
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

        $details =
            DB::table('imported_data_usages AS i')
            ->selectRaw('s.name, s.id, i.song_file_name, has_fee, owner_types, SUM(times) AS total_times,
                        (case when has_fee <> 0 then SUM(times) else 0 end) AS total_money,
                        (case when has_fee <> 0 then SUM(times) * percentage / 100 else 0 end) AS discount,
                        percentage')
            ->join('songs AS s', function($join) {
                $join->on('i.song_id', '=', 's.id');
            })
            ->join(DB::raw('(select song_id, SUM(percentage) AS percentage,
                    FROM content_owner_song
                    WHERE content_owner_id = ?
                    GROUP BY song_id) AS t'
            ), 'i.song_id', '=', 't.song_id')
            ->whereBetween('i.date', ['?', '?'])
            ->groupBy('i.song_file_name')
            ->setBindings([$request->id, $startDate, $stopDate]);

        return Datatables::of($details)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                    $query->where('s.name', 'like', '%' . $request->name . '%');
                }
                if ($request->has('file_name')) {
                    $query->where('s.file_name', 'like', '%' . $request->file_name . '%');
                }
                if ($request->has('owner-types')) {
                    $ownerTypes = $request['owner-types'];
                    $ownerTypes = array_filter($ownerTypes);
                    if (count($ownerTypes) > 0) {
                        $havingRawQuery = $this->createHavingOwnerTypes($ownerTypes);
                        $havingRawQuery = '1';
                        $query->havingRaw($havingRawQuery);
                    }
                }
            })
            ->addColumn('actions', function ($contentOwnerReport) {
                return $this->generateActionColumn($contentOwnerReport);
            })
            ->setTransformer(new ContentOwnerDetailReportTransformer)
            ->make(true);
    }

    private function createHavingOwnerTypes($ownerTypes)
    {
        $havingRawQuery = '';
        $nRealOwnerTypes = 0;

        foreach ($ownerTypes as $ownerType) {
            if ($nRealOwnerTypes == 0) {
                $havingRawQuery .= "INSTR(owner_types, '{$ownerType}') > 0";
                $nRealOwnerTypes++;
            } else {
                $havingRawQuery .= " AND INSTR(owner_types, '{$ownerType}') > 0";
            }
        }

        return $havingRawQuery;
    }

    protected function getActionColumnPermissions($song)
    {
        return [
            //
        ];
    }
}
