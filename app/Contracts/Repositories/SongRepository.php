<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface SongRepository
{
    public function getDatatables(Request $request);
}