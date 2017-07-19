<?php

namespace App\Http\Controllers;

use Auth;
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

    public function show($id)
    {
        $ktv = Ktv::findOrFail($id);

        return response()->json(['data' => $ktv, 'msg' => "Success"], 200);
    }

    public function create()
    {
        $provinces = Province::all();

        return view('ktvs.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $user = User::create([
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
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'user_id' => $user->id,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
        ]);

        flash()->success('Success!', 'Tạo đơn vị kinh doanh thành công.');

        return redirect()->route('ktvs.edit', ['id' => $ktv->id]);
    }

    public function edit($id)
    {
        $ktv = Ktv::findOrFail($id);
        $provinces = Province::all();
        $districts = District::where('province_id', $ktv->province_id)->get();

        return view('ktvs.edit', compact('ktv', 'provinces', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $ktv = Ktv::findOrFail($id);
        $ktv->update([
            'name' => $request->name,
            'representative' => $request->representative,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'updated_by' => Auth::id()
        ]);
        $ktv->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('123456')
        ]);

        flash()->success('Success!', 'Chỉnh sửa đơn vị kinh doanh thành công.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $ktv = Ktv::findOrFail($id);
        $ktv->user->delete();
        $provinces = Province::all();

        flash()->success('Success!', 'Xóa đơn vị kinh doanh thành công.');

        return view('ktvs.index', compact('provinces'));
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
