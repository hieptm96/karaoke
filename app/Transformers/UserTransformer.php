<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(array $user)
    {
        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $this->getRoles($user['id']),
            'created_at' => $user['created_at'],
            'updated_at' => $user['updated_at'],
            'actions' => $user['actions'],
        ];
    }

    protected function getRoles($user_id)
    {
        $user = \App\Models\User::find($user_id);

        $str = '';
        foreach ($user->roles as $role) {
            $str .= '<span class="label label-success">' . $role->name . '</span>';
        }

        return $str;
    }
}
