<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface ContentOwnerRepository
{
    public function getDatatables(Request $request);
}