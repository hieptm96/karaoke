<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Song;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Requests\SongRequest;
use App\Contracts\Repositories\SongRepository;

class SongsController extends Controller
{
    protected $songRepository;

    public function __construct(SongRepository $songRepository)
    {
        $this->songRepository = $songRepository;

        view()->share('provinces', Province::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('songs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('songs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SongRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SongRequest $request)
    {
        $result = $this->songRepository->create($request);

        if ($result != null) {
            flash()->success('Success!', 'Đã thêm thành công bài hát.');
            return redirect()->route('songs.show', ['id' => $result->id ])
                    ->with('created', true);
        } else {
            flash()->warning('Error!', 'Không thể thêm bài hát.');
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
        $song = $this->songRepository->find($id);

        if ($song != null) {
            return view('songs.show', ['song' => $song]);
        } else {
            return redirect()->route('songs.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SongRequest  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(SongRequest $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SongRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, SongRequest $request)
    {
        $success = $this->songRepository->update($id, $request);

        if ($success) {
            flash()->success('Success!', 'Đã sửa thành công bài hát.');
        } else {
            flash()->warning('Error!', 'Đã có lỗi xảy ra.');
        }

        return redirect()->route('songs.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = $this->songRepository->delete($id);

        if ($success) {
            flash()->success('Success!', 'Đã xóa bài hát.');
        } else {
            flash()->warning('Error!', 'Đã có lỗi xảy ra.');
        }

        return redirect()->route('songs.index');
    }

    /*
     * API for datatable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mix
     */
    public function datatables(Request $request)
    {
        return $this->songRepository->getDatatables($request);
    }
}
