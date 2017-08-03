<?php

namespace App\Http\Controllers;

use DB;
use Datatables;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\ContentOwnerSong;
use App\Transformers\ContentOwnerSongTransformer;

class ContentOwnerSongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('content_owner_song.index', ['id' => $id]);
    }

    public function datatables(Request $request, $id)
    {
        $songs = Song::with('contentOwnerSongs')
                    ->whereHas('contentOwnerSongs', function($q) use ($id){
                        $q->where('content_owner_id', $id);
                    });

        return Datatables::of($songs)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                    $param = '%'.$request->name.'%';

                    $query->where(function ($q) use ($param) {
                        $q->where('name', 'like', $param)
                            ->orWhere('abbr', 'like', $param)
                            ->orWhere('name_raw', 'like', $param);
                    });
                }
                if ($request->has('ownerTypes')) {
                    $ownerTypes = $request->ownerTypes;

                    $query->whereHas('contentOwnerSongs', function($q) use ($ownerTypes) {
                        $q->selectRaw('count(*) as count')
                          ->whereIn('type', $ownerTypes)
                          ->groupBy('song_id')
                          ->having('count', '>=', count($ownerTypes));
                    });
                }
            })
            ->setTransformer(new ContentOwnerSongTransformer)
            ->make(true);
    }
}
