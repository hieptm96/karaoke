<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
use Zizaco\Entrust\EntrustPermission;
use Illuminate\Support\Facades\Route;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Permission extends EntrustPermission implements AuditableContract
{
    use Auditable;

    protected $fillable = ['name', 'display_name', 'description'];

    public function syncFromRouting()
    {
        $results = [];

        foreach (Route::getRoutes() as $route) {
            $results[] = $this->filterRoute($route);
        }

        $results = array_values(array_filter($results));

        foreach ($results as $route) {
            $permission = static::firstOrNew(['name' => $route['name']]);

            $permission->fill([
                'display_name' => $route['name'],
            ])->save();
        }
    }

    protected function filterRoute($route)
    {
        if (! in_array('web', $route->middleware())) {
            return ;
        }

        $action = $route->getActionName();

        if ($action == 'Closure') {
            return ;
        }

        $controller = get_controller_name($action);

        return [
            'uri'    => $route->uri(),
            'name'   => $route->getName() ? $route->getName() : $controller.'.'.get_action_name($action),
            'action' => $action,
            'controller' => $controller,
        ];
    }
}
