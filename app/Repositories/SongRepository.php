<?php

namespace App\Repositories;

use Datatables;
use App\Models\Song;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Transformers\SongTransformer;
use App\Contracts\Repositories\SongRepository as Contract;

class SongRepository implements Contract
{
    use HasActionColumn;

    public static $config;

    static function init()
    {
        self::$config = json_decode(\App\Models\Config::orderBy('updated_at')->first()->config, true);
    }

    public function __construct()
    {
        if (is_null(static::$config)) {
            static::init();
        }
    }

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
                if ($request->has('filename')) {
                    $param = '%'.$request->filename.'%';

                    $query->where(function ($q) use ($param) {
                        $q->where('file_name', 'like', $param);
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
            ->rawColumns(['actions'])
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

        $owners = $this->getOwners($request, $song->file_name);
        $song->contentOwners()->sync($owners);

        return $song;
    }

    private static $percentType =
        ['musican' => 'musician_rate', 'title' => 'title_rate',
            'singer' => 'singer_rate', 'film' => 'film_rate'];

    public function getDefaultPercentage($ownerType)
    {
        return static::$config[static::$percentType[$ownerType]];
    }

    public function getOwners($request, $songFileName)
    {
        $owners = [];

        if (!empty($request['singer-owner'])) {
            $defaultPercentage = $this->getDefaultPercentage('singer');
            $owners[] = ['content_owner_id' => $request['singer-owner'],
                    'type' => 'singer', 'percentage' => $defaultPercentage,
                    'song_file_name' => $songFileName];
        }

        if (!empty($request['musican-owner'])) {
            $defaultPercentage = $this->getDefaultPercentage('singer');
            $owners[] = ['content_owner_id' => $request['musican-owner'],
                    'type' => 'musican', 'percentage' => $defaultPercentage,
                    'song_file_name' => $songFileName];
        }

        if (!empty($request['title-owner'])) {
            $defaultPercentage = $this->getDefaultPercentage('singer');
            $owners[] = ['content_owner_id' => $request['title-owner'],
                    'type' => 'title', 'percentage' => $defaultPercentage,
                    'song_file_name' => $songFileName];
        }

        if (!empty($request['film-owner'])) {
            $defaultPercentage = $this->getDefaultPercentage('singer');
            $owners[] = ['content_owner_id' => $request['film-owner'],
                    'type' => 'film', 'percentage' => $defaultPercentage,
                    'song_file_name' => $songFileName];
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

        $success = true;

        $song->update($request->toArray());

        $singerIds = $request->singer;

        if ($singerIds != null) {
            $song->singers()->sync($singerIds);
        } else {
            $song->singers()->detach();
        }


        $owners = $this->getOwners($request, $song->file_name);
        $song->contentOwners()->detach();
        $song->contentOwners()->attach($owners);

        return $success;
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
            'songs.edit' => '<a class="btn btn-primary btn-xs waves-effect waves-light" href="' . route('songs.edit', $song['file_name'])
                . '"><i class="fa fa-edit"></i> Sửa</a>',
            'songs.delete' => ' <a class="btn btn-default delete-song btn-xs waves-effect waves-light" data-toggle="modal" data-target="#delete-song-modal"><i class="fa fa-trash"></i> Xóa</a>'
        ];
    }
}
