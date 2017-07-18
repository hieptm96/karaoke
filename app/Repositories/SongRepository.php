<?php

namespace App\Repositories;

use Datatables;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Transformers\SongTransformer;
use App\Contracts\Repositories\SongRepository as Contract;

class SongRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        $songs = Song::with('singers', 'createdBy');

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
            ->setTransformer(new SongTransformer)
            ->make(true);
    }

    protected function getActionColumnPermissions($song)
    {
        return [
            //
        ];
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> develop
