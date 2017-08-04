<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
use Zizaco\Entrust\EntrustRole;
use Illuminate\Support\Facades\Route;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Role extends EntrustRole implements AuditableContract
{
    use Auditable;

    protected $fillable = ['name', 'display_name', 'description'];
}