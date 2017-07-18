<?php

namespace App\Repositories;

use Datatables;
use App\Models\Singer;
use Illuminate\Http\Request;
use App\Transformers\SingerTransformer;
use App\Contracts\Repositories\SingerRepository as Contract;

class SingerRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        $singers = Singer::with('createdBy');

        return Datatables::of($singers)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                    $param = '%'.$request->name.'%';

                    $query->where('name', 'like', $param)
                        ->orWhere('abbr', 'like', $param)
                        ->orWhere('name_raw', 'like', $param);
                }
            })
            ->addColumn('actions', function ($singers) {
                return $this->generateActionColumn($singers);
            })
            ->setTransformer(new SingerTransformer)
            ->make(true);
    }

    protected function getActionColumnPermissions($singers)
    {
        return [
            //
        ];
    }
}
