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
        $result = Song::with('singers', 'createdBy', 'contentOwners')->find($id);
        //return $result;
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
        $song = Song::create($request->toArray());

        if ($song == null) {
            return null;
        }

        $singerIds = $request->singer;
        if ($singerIds != null) {
            $song->singers()->sync($singerIds);
        }

        $owners = $this->getOwners($request);
        $song->contentOwners()->sync($owners);

        return $song;
    }

    private static $percentType =
        ['musican' => 33, 'title' => 28, 'singer' => 15, 'film' => 24];

    private static function getDefaultPercentage($ownerType)
    {
        return static::$percentType[$ownerType];
    }

    public function getOwners($request)
    {
        $owners = [];

        if (!empty($request['singer-owner'])) {
            $defaultPercentage = static::getDefaultPercentage('singer');
            $owners[] = ['content_owner_id' => $request['singer-owner'],
                    'type' => 'singer', 'percentage' => $defaultPercentage];
        }

        if (!empty($request['musican-owner'])) {
            $defaultPercentage = static::getDefaultPercentage('musican');
            $owners[] = ['content_owner_id' => $request['musican-owner'],
                    'type' => 'musican', 'percentage' => $defaultPercentage];
        }

        if (!empty($request['title-owner'])) {
            $defaultPercentage = static::getDefaultPercentage('title');
            $owners[] = ['content_owner_id' => $request['title-owner'],
                    'type' => 'title', 'percentage' => $defaultPercentage];
        }

        if (!empty($request['film-owner'])) {
            $defaultPercentage = static::getDefaultPercentage('film');
            $owners[] = ['content_owner_id' => $request['film-owner'],
                    'type' => 'film', 'percentage' => $defaultPercentage];
        }

        $nOwners = count($owners);
        $getMaximumOwners = 4;
        if ($nOwners == $getMaximumOwners) {
            return $owners;
        }

        $sumPercent = 0;

        foreach ($owners as $key => $owner) {
            $sumPercent += $owner['percentage'];
        }

        foreach ($owners as $key => &$owner) {
            $realPercent = floatval($owner['percentage']) / $sumPercent * 100;
            $owner['percentage'] = round($realPercent);
        }

        return $owners;
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $song = Song::findOrFail($id);

        $song->update($request->toArray());

        $singerIds = $request->singer;

        if ($singerIds != null) {
            $song->singers()->sync($singerIds);
        } else {
            $song->singers()->detach();
        }

        $owners = $this->getOwners($request);
        $song->contentOwners()->detach();
        $song->contentOwners()->attach($owners);

        return $song;
    }

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $song = Song::findOrFail($id);

        $success = $song->delete();

        return $success;
    }


    protected function getActionColumnPermissions($song)
    {
        return [
            //
        ];
    }
}
