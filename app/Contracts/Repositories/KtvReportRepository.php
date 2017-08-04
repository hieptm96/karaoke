<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface KtvReportRepository
{
    public function getDatatables(Request $request);

    public function getDetailDatatables(Request $request);
}