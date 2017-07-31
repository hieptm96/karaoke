<?php

namespace App\Transformers;

use App\Models\Song;
use League\Fractal\TransformerAbstract;
use Barryvdh\Debugbar\Facade as Debugbar;

class SongTransformer extends TransformerAbstract
{
    public function transform(array $song)
    {
        return [
            'id' => $song['id'],
            'name' => '<a href="'.route('songs.show', $song['id']).'">'.$song['name'].'</a>',
            'language' => config('ktv.languages.'.$song['language'], ''),
            'singers' => $this->getSingers($song),
            'created_by' => $song['created_by']['name'],
            'created_at' =>  $song['created_at'],
            'updated_at' =>  $song['updated_at'],
            'actions' => $this->generateActions($song),
        ];
    }

    public function transformWithoutLink(Song $song)
    {
        return [
            'id' => $song->id,
            'name' => $song->name,
            'language' => $song->language,
            'singers' => $this->getSingerUrls($song),
            'created_by' => $song->createdBy->name,
            'created_at' => $song->created_at->toDateTimeString(),
            'updated_at' => $song->updated_at->toDateTimeString(),
            'contentOwners' => $this->getContentOwners($song),
        ];
    }

    protected function getContentOwners($song)
    {
        $owners = [];

        foreach ($song['contentOwners'] as $owner) {
            // $owners[] = [ $owner['pivot']['type'] =>
            //                 ['id' => $owner['id'], 'name' => $owner['name']] ];
            $owners[$owner['pivot']['type']] = ['id' => $owner['id'], 'name' => $owner['name']];
        }

        return $owners;
    }

    protected function getSingerUrls($song)
    {
        $singers = [];

        foreach ($song->singers as $singer) {
            $singer->name = '<a href="'.route('singers.show', $singer->id).'">'.$singer->name.'</a>';
        }

        return $song->singers;
    }

    protected function getSingers($song)
    {
        $singers = [];

        foreach ($song['singers'] as $singer) {
            $singers[] = '<a href="'.route('singers.show', $singer['id']).'">'.$singer['name'].'</a>';
        }

        return implode(', ', $singers);
    }

    private function generateActions($song)
    {
        $actions = '<a class="btn btn-primary btn-xs waves-effect waves-light" href="' . route('songs.show', $song['id'])
                    . '"><i class="fa fa-edit"></i> Sửa</a>';
        $actions .= ' <a class="btn btn-default delete-song btn-xs waves-effect waves-light" data-toggle="modal" data-target="#delete-song-modal"><i class="fa fa-trash"></i> Xóa</a>';


        return $actions;
    }
}
