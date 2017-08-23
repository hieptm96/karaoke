<?php

namespace App\Contracts\Repositories;

use App\Models\Ktv;
use Illuminate\Http\Request;

interface KtvReportRepository
{
    public function getDatatables(Request $request);

    public function getDetailDatatables(Request $request);

    public function getBoxesDetailDatatables(Ktv $ktv, Request $request);
}