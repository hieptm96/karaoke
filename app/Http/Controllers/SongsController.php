<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use App\Contracts\Repositories\SongRepository;

class SongsController extends Controller
{
    protected $songRepository;

    public function __construct(SongRepository $songRepository)
    {
        $this->songRepository = $songRepository;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $singers = $request->singer;
        if ($singers == null) {
            $singers = [];
        }

        $name = $request->name;
        $language = $request->language;

        $result = $this->songRepository->create(
            ['name' => $name, 'language' => $language, 'created_by' => 1, 'updated_by' => 1],
            $singers);

        if ($result != null) {
            return redirect('/songs/' . $result['id'])->with('created', true);
        } else {
            return view('songs.create', ['created' => false]);
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
            return view('songs.show-song', ['song' => $song]);
        } else {
            return redirect('/songs');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $singers = $request->singer;
        if ($singers == null) {
            $singers = [];
        }

        $name = $request->name;
        $language = $request->language;

        $result = $this->songRepository->update($id,
                    ['name' => $name, 'language' => $language]
                    , $singers);

        if ($result === null) {
            return back();
        } else {
            return redirect('/songs/' . $id)->with('edited', $result);
        }
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
            return view('songs.deleted');
        } else {
            return redirect('/songs/' . $id)->with('delete', false);;
        }
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
