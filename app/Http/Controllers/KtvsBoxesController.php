<?php

namespace App\Http\Controllers;

use App\Models\Ktv;
use App\Models\Box;
use Illuminate\Http\Request;
use App\Http\Requests\KtvsBoxsRequest;
use App\Repositories\KtvsBoxesRepository;

class KtvsBoxesController extends Controller
{

    protected $ktvsBoxesRepository;

    public function __construct(KtvsBoxesRepository $ktvsBoxesRepository)
    {
        $this->ktvsBoxesRepository = $ktvsBoxesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Ktv  $ktv
     * @return \Illuminate\Http\Response
     */
    public function index(Ktv $ktv)
    {
        $boxes = $ktv->boxes;

        return view('ktvs.boxes.index', ['ktv' => $ktv]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Ktv $ktv)
    {
        return view('ktvs.boxes.create', ['ktv' => $ktv]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Ktv $ktv
     * @param KtvsBoxsRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Ktv $ktv, KtvsBoxsRequest $request)
    {
        $box = Box::withTrashed()
                    ->where('code', '=', $request->code)
                    ->first();

        if ($box != null) {
            $box->deleted_at = null;
            $box->info = $request->info;
            $box->ktv_id = $ktv->id;
            $box->save();
        } else {
            $box = Box::firstOrNew(['code' => $request->code]);

            $box->code = $request->code;
            $box->info = $request->info;

            $ktv->boxes()->save($box);
        }

        flash()->success('Thành công!', 'Đã thêm thành công đầu máy/thiêt bị phát.');

        return redirect()->route('ktvs.boxes.edit', ['ktv' => $ktv->id, 'box' => $box->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param $ktv_id
     * @param $box_id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($ktv_id, $box_id)
    {
        $ktv = Ktv::findOrFail($ktv_id);

        $box = Box::where('ktv_id', '=', $ktv_id)
            ->findOrFail($box_id);


        return view('ktvs.boxes.show', ['ktv' => $ktv, 'box' => $box]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $ktv_id
     * @param $box_id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit($ktv_id, $box_id)
    {
        $ktv = Ktv::findOrFail($ktv_id);

        $box = Box::where('ktv_id', '=', $ktv_id)
                    ->findOrFail($box_id);


        return view('ktvs.boxes.edit', ['ktv' => $ktv, 'box' => $box]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Ktv $ktv
     * @param Box $box
     * @param KtvsBoxsRequest|Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Ktv $ktv, Box $box, KtvsBoxsRequest $request)
    {

        $success = $box->update($request->toArray());

        if ($success) {
            flash()->success('Thành công!', 'Đã sửa thành công đầu máy/thiêt bị phát.');
        } else {
            flash()->warning('Lỗi!', 'Đã có lỗi xảy ra.');
        }

        return redirect()->route('ktvs.boxes.edit', ['ktv' => $ktv, 'box' => $box]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ktv $ktv
     * @param Box $box
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Ktv $ktv, Box $box)
    {
        $success = $box->delete();

        if ($success) {
            flash()->success('Thành công!', 'Xóa đầu máy/thiết bị phát thành công.');
        } else {
            flash()->warning('Lỗi!', 'Không thể xóa đầu máy/thiết bị phát.');
        }

        return redirect()->route('ktvs.boxes.index', ['ktv' => $ktv->id]);
    }

    /**
     * @param Ktv $ktv
     * @return string
     */
    public function getBoxesByKtv(Ktv $ktv) {
        $boxes = $ktv->boxes;

        $this->ktvsBoxesRepository->getBoxesByKtvId($ktv->id);

        return json_encode($boxes);
    }

    /**
     * @param Ktv $ktv
     * @return string
     */
    public function datatables(Ktv $ktv)
    {
        return $this->ktvsBoxesRepository->getBoxesByKtv($ktv);
    }
}
