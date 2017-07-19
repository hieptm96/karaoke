<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface KtvRepository
{
    public function getDatatables(Request $request);
}