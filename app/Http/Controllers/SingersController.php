<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Singer;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Barryvdh\Debugbar\Facade as Debugbar;

class SingersController extends Controller
{
    public function index()
    {
        // $name = 'hưng';
        //$singers = Singer::take(10)->get();
        // $singers = Singer::where('name', 'like', '%' . $name . '%' )
        //                   ->orWhere('abbr', 'like', '%' . $name . '%')
        //                   ->get();

        // $singers = Singer::where('name', 'REGEXP', '(.*)' . $name . '(.*)' )
        //                   ->get();

        //  $singers = Singer::find(1);
        $singers = Singer::with('createdBy')->take(10)->get();

        Debugbar::info($singers[0]);
        // Debugbar::info(var_dump($singers[0]->created_by_user));

        return view('singers.index', ['singers' => $singers]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $singers = Singer::where('name', 'like', '%' . $query . '%' )
                          ->orWhere('abbr', 'like', '%' . $query . '%')
                          ->get();

        return view('singers.index', ['singers' => $singers, 'query' => $query]);
    }

    public function edit(Request $request)
    {
        $singerID = $request->input('singerID');
        $newName = $request->input('name');
        $newSex = $request->input('sex');

        $singer = Singer::find($singerID);
        $singer->name = $newName;
        $singer->sex = $newSex;

        $singer->save();

        // $deletedRows = Singer::where('id', $singerID)
        //                       ->update(['name' => $newName, 'sex' => $newSex]);

        return back();
    }

    public function delete(Request $request)
    {
        $singerID = $request->input('singerID');

        $deletedRows = Singer::where('id', $singerID)->delete();

        Debugbar::info($deletedRows);
        //return Response::json($deletedRows);

        return redirect('singers');
    }
}
