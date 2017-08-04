<?php

namespace App\Repositories;

use Datatables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Contracts\Repositories\UserRepository as Contract;

class UserRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);

        return Datatables::of($users)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                    $param = '%'.$request->name.'%';
                    $query->where('name', 'like', $param);
                }
                if ($request->has('email')) {
                    $query->where('email', 'like', '%'.$request->email.'%');
                }
            })
            ->addColumn('actions', function ($user) {
                return $this->generateActionColumn($user);
            })
            ->setTransformer(new UserTransformer)
            ->rawColumns(['actions'])
            ->make(true);
    }

    protected function getActionColumnPermissions($user)
    {
        return [
            'users.edit' => '<a class="btn btn-primary btn-xs waves-effect waves-light" href="' . route('users.edit', $user->id)
                . '"><i class="fa fa-edit"></i> Sửa</a>',
            'users.delete' => ' <a class="btn btn-default delete-song btn-xs waves-effect waves-light" data-toggle="modal" data-target="#delete-song-modal"><i class="fa fa-trash"></i> Xóa</a>'
        ];
    }

}
