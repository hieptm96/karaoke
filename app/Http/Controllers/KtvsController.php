<?php

namespace App\Http\Controllers;

use App\Models\Ktv;
use App\Models\User;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Contracts\Repositories\KtvRepository;

class KtvsController extends Controller
{
    protected $songRepository;

    public function __construct(KtvRepository $ktvRepository)
    {
        $this->ktvRepository = $ktvRepository;
    }

    public function index()
    {
        $provinces = Province::all();
        return view('ktvs.index', compact('provinces'));
    }

    public function create()
    {
        $provinces = Province::all();
        return view('ktvs.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $user = User::forceCreate([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('123456')
        ]);
        $ktv = Ktv::forceCreate([
            'name' => $request->name,
            'representative' => $request->representative,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'province_id' => $request->province,
            'district_id' => $request->district,
            'user_id' => $user->id
        ]);
        flash()->success('Success!', 'Tạo đơn vị kinh doanh thành công.');

        return redirect()->route('ktvs.index');
    }

    public function show(Song $song)
    {
        //
    }

    public function edit($id)
    {
        $ktv = Ktv::findOrFail($id);
        $provinces = Province::all();
        return view('ktvs.edit', compact('ktv', 'provinces'));
    }

    public function update(Request $request, Song $song)
    {
        //
    }

    public function destroy(Song $song)
    {
        //
    }

    public function getDistricts(Request $request)
    {
        $districts = District::where('province_id', $request->province_id)->get();
        return response()->json(['data' => $districts, 'msg' => "Success"], 200);
    }

    public function datatables(Request $request)
    {
        return $this->ktvRepository->getDatatables($request);
    }
}
