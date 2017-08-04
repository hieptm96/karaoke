<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

trait HasActionColumn
{
    public function generateActionColumn($item)
    {
        if (! method_exists($this, 'getActionColumnPermissions')) {
            return [];
        }

        $actionColumn = [];

        $user = Auth::user();

        $permissions = $this->getActionColumnPermissions($item);

        foreach ($permissions as $key => $value) {
            if ($user->can($key)) {
                $actionColumn[] = $value;
            }
        }

        return implode(' ', $actionColumn);
    }
}
