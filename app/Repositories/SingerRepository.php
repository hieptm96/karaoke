<?php

namespace App\Repositories;

use Datatables;
use App\Models\Singer;
use Illuminate\Http\Request;
use App\Transformers\SingerTransformer;
use Barryvdh\Debugbar\Facade as Debugbar;
use App\Contracts\Repositories\SingerRepository as Contract;

class SingerRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        $singers = Singer::with('createdBy')->select('*');

        return Datatables::of($singers)
            ->filter(function ($query) use ($request) {
                Debugbar::info($request->input('sex'));
                if ($request->has('name')) {
                    $param = '%'.$request->name.'%';
                    // $query->where('name', 'like', $param)
                    //     ->orWhere('abbr', 'like', $param)
                    //     ->orWhere('name_raw', 'like', $param);

                    $query->where(function ($query) use ($param) {
                        $query->where('name', 'like', $param)
                            ->orWhere('abbr', 'like', $param)
                            ->orWhere('name_raw', 'like', $param);
                    });
                }
                if ($request->has('createdBy')) {
                    $name = '%'.$request->createdBy.'%';
                    $query->whereHas('createdBy', function($q) use ($name) {
                        $q->where('name', 'like', $name);
                    });
                }
                if ($request->has('sex')) {
                     $query->where('sex', $request->sex);
                }
                if ($request->has('language')) {
                   $query->where('language', $request->language);
                }
            })
            ->addColumn('actions', function ($singers) {
                return $this->generateActionColumn($singers);
            })
            ->setTransformer(new SingerTransformer)
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
    }


    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes)
    {

    }

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
    }

    protected function getActionColumnPermissions($singer)
    {
        return [
            'singers.edit' => '<a class="btn btn-primary btn-xs waves-effect waves-light" href="' . route('singers.edit', $singer['id'])
                . '"><i class="fa fa-edit"></i> Sửa</a>',
            'singers.destroy' => '<a class="btn btn-default delete-singer btn-xs waves-effect waves-light" data-toggle="modal" data-target="#delete-singer-modal"><i class="fa fa-trash"></i> Xóa</a>',
        ];
    }
}
