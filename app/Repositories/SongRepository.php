<?php

namespace App\Repositories;

use Datatables;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Transformers\SongTransformer;
use App\Contracts\Repositories\SongRepository as Contract;

class SongRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {

        $songs = Song::with('singers', 'createdBy', 'contentOwners');

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
                if ($request->has('singer')) {
                    $param = '%'.$request->singer.'%';
                    $query->whereHas('singers', function($q) use ($param) {
                        $q->where('name', 'like', $param)
                            ->orWhere('abbr', 'like', $param)
                            ->orWhere('name_raw', 'like', $param);
                    });
                }
                if ($request->has('createdBy')) {
                    $name = '%'.$request->createdBy.'%';
                    $query->whereHas('createdBy', function($q) use ($name) {
                        $q->where('name', 'like', $name);
                    });
                }
                if ($request->has('language')) {
                   $query->where('language', $request->language);
                }
            })
            ->addColumn('actions', function ($song) {
                return $this->generateActionColumn($song);
            })
            ->setTransformer(new SongTransformer)
            ->make(true);
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = Song::with('singers', 'createdBy')->find($id);
        if ($result != null) {
            $songTransformer = new SongTransformer;
            $result = $songTransformer->transformWithoutLink($result);
        }

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(Request $request)
    {
        $name = $request->name;
        $language = $request->language;

        $attributes =['name' => $name, 'language' => $language, 'created_by' => 1, 'updated_by' => 1];

        $song = Song::create($attributes);

        $singerIds = $request->singer;
        if ($singerIds == null) {
            $singerIds = [];
        }

        if ($song == null) {
            return null;
        }

        if ($singerIds != null) {
            $song->singers()->sync($singerIds);
        }

        return $song;
    }

    private static $percentType =
        ['musican' => '40', 'title' => '30', 'singer' => 20, 'film' => 10];

    private function getOwner($request)
    {
        $owners = [];
        $singerOwner = $request['singer-owner'];

        if (!empty($request['singer-owner'])) {
            $owners[ $request['singer-owner'] ] = ['type' => 'singer'];
        }

        if (!empty($request['musican-owner'])) {
            $owners[ $request['musican-owner'] ] = ['type' => 'musican'];
        }

        if (!empty($request['singer-owner'])) {
            $owners[ $request['title-owner'] ] = ['type' => 'title'];
        }

        if (!empty($request['singer-owner'])) {
            $owners[ $request['film-owner'] ] = ['type' => 'film'];
        }

        $musicanOwner = $request['musican-owner'];
        $titleOwner = $request['title-owner'];
        $filmOwner = $request['film-owner'];
    }


    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes, array $singerIds)
    {
        $song = Song::find($id);

        if ($song) {
            $success = $song->update($attributes);
            $song->singers()->sync($singerIds);
            return $song;
        }

        return null;
    }

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $result = Song::find($id);

        if($result) {
            $result->delete();
            return true;
        }

        return false;
    }


    protected function getActionColumnPermissions($song)
    {
        return [
            //
        ];
    }
}
