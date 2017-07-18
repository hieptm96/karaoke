<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface SingerRepository
{
    public function getDatatables(Request $request);
}
