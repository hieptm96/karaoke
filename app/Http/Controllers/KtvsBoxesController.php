<?php

namespace App\Http\Controllers;

use App\Models\Ktv;
use App\Models\Box;
use Illuminate\Http\Request;

class KtvsBoxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Ktv  $ktv
     * @return \Illuminate\Http\Response
     */
    public function index(Ktv $ktv)
    {
        $boxes = $ktv->boxes;

        return view('ktvs.boxes.index');
        dd($boxes);
        
        dd(route('ktv.boxes.index', ['ktv_id' => 5]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ktv_id, $box_id)
    {
        $box = Box::where('ktv_id', '=', $ktv_id)
                    ->findOrFail($box_id);

        $ktv = Ktv::findOrFail($ktv_id);

        return view('ktvs.boxes.edit', ['ktv' => $ktv, 'box' => $box]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
