<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Ktv;
use App\Models\User;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Requests\KtvRequest;
use App\Contracts\Repositories\KtvRepository;

class KtvsController extends Controller
{
    protected $ktvRepository;

    public function __construct(KtvRepository $ktvRepository)
    {
        $this->ktvRepository = $ktvRepository;

        view()->share('provinces', Province::all());
    }

    public function index()
    {
        return view('ktvs.index');
    }

    public function show($id)
    {
        $ktv = Ktv::findOrFail($id);

        return response()->json(['data' => $ktv, 'msg' => "Success"], 200);
    }

    public function create()
    {
        return view('ktvs.create');
    }

    public function store(KtvRequest $request)
    {
        $password = ($request->password) ? $request->password : '123456';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password)
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

        $role = \App\Models\Role::where('name', 'business_unit')->first();
        $user->attachRole($role);

        flash()->success('Success!', 'Tạo đơn vị kinh doanh thành công.');

        return redirect()->route('ktvs.edit', ['id' => $ktv->id]);
    }

    public function edit($id)
    {
        $ktv = Ktv::findOrFail($id);

        $districts = District::where('province_id', $ktv->province_id)->get();

        return view('ktvs.edit', compact('ktv', 'districts'));
    }

    public function update(KtvRequest $request, $id)
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
        if ($request->password) {
            $ktv->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        } else {
            $ktv->user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }


        flash()->success('Success!', 'Chỉnh sửa đơn vị kinh doanh thành công.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $ktv = Ktv::findOrFail($id);
        $ktv->boxes()->delete();
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
