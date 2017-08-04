<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface UserRepository
{
    public function getDatatables(Request $request);
}