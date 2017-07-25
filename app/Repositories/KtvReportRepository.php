<?php

namespace App\Repositories;

use Datatables;
use Illuminate\Http\Request;
use App\Contracts\Repositories\KtvReportRepository as Contract;

class KtvReportRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        $songs = \App\Models\Song::with('singers', 'createdBy');

        return Datatables::of($songs)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                    $param = '%'.$request->name.'%';

                    $query->where('name', 'like', $param)
                        ->orWhere('abbr', 'like', $param)
                        ->orWhere('name_raw', 'like', $param);
                }
            })
            ->addColumn('actions', function ($song) {
                return $this->generateActionColumn($song);
            })
            ->make(true);
    }

    protected function getActionColumnPermissions($song)
    {
        return [
            //
        ];
    }
}