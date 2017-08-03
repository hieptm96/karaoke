<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface ContentOwnerReportRepository
{
    public function getDatatables(Request $request);
}
