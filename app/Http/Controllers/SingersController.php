<?php

namespace App\Http\Controllers;

use App\Models\Singer;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $sex = $request->input('sex');
        $language = $request->input('language');

        if (empty($name) || !$this->isValidSex($sex)
                    || !$this->isValidLanguage($language)) {
            return 1;
            return redirect('/singers');
        }

        $result = $this->singerRepository->create(['name' => $name, 'sex' => $sex,
                    'language' => $language, 'created_by' => 1, 'updated_by' => 1]);

        if ($result != null) {
            return redirect('/singers/' . $result['id'])->with('created', true);
        } else {
            return view('singers.create', ['created' => false]);
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
        // $singer = Singer::with('createdBy')->find($id);

        $singer = Singer::find($id);

        if ($singer != null) {
            $singer = SingerTransformer::transformWithoutLink($singer);
            return view('singers.show-singer', ['singer' => $singer]);
        } else {
            return redirect('/singers');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        $sex = $request->input('sex');
        $language = $request->input('language');

        if (empty($name) || !$this->isValidSex($sex)
                    || !$this->isValidLanguage($language)) {
            return redirect('/singers');
        }

        $result = $this->singerRepository->update($id,
                      ['name' => $name, 'sex' => $sex, 'language' => $language]);

        if ($result === null) {
            return back();
        } else {
            return redirect('/singers/' . $id)->with('edited', $result);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = $this->singerRepository->delete($id);
        if ($success) {
            return view('singers.deleted');
        } else {
            return redirect('/singers/' . $id)->with('delete', false);;
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
        return $this->singerRepository->getDatatables($request);
    }

    /*
     * check $sex
     *
     * @param  $sex
     * @return true if $sex is valid, other wise return false
     */
    private function isValidSex($sex)
    {
        $sex = (int)$sex;
        // hard code: range of sex
        return !empty($sex) && $sex >= 1 && $sex <= 3;
    }


    /*
     * check $language
     *
     * @param  $sex
     * @return true if $sex is valid, other wise return false
     */
    private function isValidLanguage($language)
    {
        $language = (int)$language;
        // hard code: range of language
        return $language >= 0 && $language <= 3;
    }
}
