<?php

namespace App\Http\Controllers;

use App\Models\Singer;
use Illuminate\Http\Request;
use App\Http\Requests\SingerRequest;
use App\Transformers\SingerTransformer;
use Barryvdh\Debugbar\Facade as Debugbar;
use App\Contracts\Repositories\SingerRepository;

class SingersController extends Controller
{
    protected $singerRepository;

    public function __construct(SingerRepository $singerRepository)
    {
        $this->singerRepository = $singerRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('singers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('singers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SingerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SingerRequest $request)
    {

        $singer = Singer::create($request->toArray());

        if ($singer != null) {
            flash()->success('Success!', 'Đã thêm thành công ca sĩ.');
            return redirect()->route('singers.show', ['id' => $singer->id ])
                    ->with('created', true);
        } else {
            flash()->danger('Error!', 'Không thể thêm ca sĩ.');
            return redirect()->route('show.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $singer = Singer::findOrFail($id);
        $singer = SingerTransformer::transformWithoutLink($singer);

        return view('singers.show', ['singer' => $singer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $singer = Singer::findOrFail($id);
        $singer = SingerTransformer::transformWithoutLink($singer);

        return view('singers.edit', ['singer' => $singer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SongRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SingerRequest $request, $id)
    {
        $singer = Singer::findOrFail($id);
        $success = $singer->update($request->toArray());

        if ($success) {
            flash()->success('Success!', 'Đã sửa thành công ca sĩ.');
        } else {
            flash()->warning('Warning!', 'Đã có lỗi xảy ra.');
        }

        return redirect()->route('singers.edit', ['id' => $id ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $singer = Singer::findOrFail($id);
        $success = $singer->delete();

        if ($success) {
            flash()->success('Success!', 'Xóa ca sĩ thành công.');
        } else {
            flash()->warning('Error!', 'Không thể xóa ca sĩ.');
        }

        return redirect()->route('singers.index');
    }

    /*
     * API for datatable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mix
     */
    public function datatables(Request $request)
    {
        return $this->singerRepository->getDatatables($request);
    }
}
