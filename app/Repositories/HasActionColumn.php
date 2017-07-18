<?php

namespace App\Repositories;

trait HasActionColumn
{
    public function generateActionColumn($item)
    {
        if (! method_exists($this, 'getActionColumnPermissions')) {
            return [];
        }

        $actionColumn = [];


        $permissions = $this->getActionColumnPermissions($item);

        foreach ($permissions as $key => $value) {
            //need check user has access to this action
            $actionColumn[] = $value;
        }

        return implode(' ', $actionColumn);
    }
}