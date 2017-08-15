<?php

namespace App\Repositories;

use Datatables;
use App\Models\Box;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Contracts\Repositories\KtvsBoxesRepository as Contract;

class KtvsBoxesRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        // TODO: Implement getDatatables() method.
    }

    public function getBoxesByKtv($ktv)
    {
        $boxes = $ktv->boxes;

        foreach ($boxes as $box) {
            $box->{'action'} = $this->generateActionColumn($box);
        }

        return json_encode($boxes);
    }

    protected function getActionColumnPermissions($box)
    {
        return [
            'ktvs.boxes.edit' => '<a class="btn btn-primary btn-xs waves-effect waves-light" href="'
                . route('ktvs.boxes.edit', ['ktv' => $box->ktv_id, 'box' => $box->id])
                . '"><i class="fa fa-edit"></i> Sửa</a>',
            'ktvs.boxes.delete' => ' <a class="btn btn-default delete-box btn-xs waves-effect waves-light" data-toggle="modal" data-target="#delete-box-modal"><i class="fa fa-trash"></i> Xóa</a>'
        ];
    }

}
