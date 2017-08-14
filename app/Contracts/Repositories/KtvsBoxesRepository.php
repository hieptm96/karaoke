<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface KtvsBoxesRepository
{
    public function getDatatables(Request $request);

    public function getBoxesByKtv($ktv);
}