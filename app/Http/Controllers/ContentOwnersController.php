<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\District;
use App\Models\Province;
use App\Models\ContentOwner;
use Illuminate\Http\Request;
use App\Http\Requests\ContentOwnerRequest;
use App\Contracts\Repositories\ContentOwnerRepository;

class ContentOwnersController extends Controller
{
    protected $contentOwnerRepository;

    public function __construct(ContentOwnerRepository $contentOwnerRepository)
    {
        $this->contentOwnerRepository = $contentOwnerRepository;

        view()->share('provinces', Province::all());
    }

    public function index()
    {
        return view('content_owners.index');
    }

    public function show($id)
    {
        $content_owner = ContentOwner::findOrFail($id);

        return response()->json(['data' => $content_owner, 'msg' => "Success"], 200);
    }

    public function create()
    {
        return view('content_owners.create');
    }

    public function store(ContentOwnerRequest $request)
    {
        $password = ($request->password) ? $request->password : '123456';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password)
        ]);
        $content_owner = ContentOwner::forceCreate([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'code' => $request->code,
            'user_id' => $user->id,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
        ]);

        $role = \App\Models\Role::where('name', 'content_owner_unit')->first();
        $user->attachRole($role);

        flash()->success('Success!', 'Tạo đơn vị sở hữu bản quyền thành công.');

        return redirect()->route('contentowners.edit', ['id' => $content_owner->id]);
    }

    public function edit($id)
    {
        $content_owner = ContentOwner::findOrFail($id);

        $districts = District::where('province_id', $content_owner->province_id)->get();

        return view('content_owners.edit', compact('content_owner', 'districts'));
    }

    public function update(ContentOwnerRequest $request, $id)
    {
        $content_owner = ContentOwner::findOrFail($id);
        $content_owner->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'code' => $request->code,
            'updated_by' => Auth::id()
        ]);
        if ($request->password) {
            $content_owner->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        } else {
            $content_owner->user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }


        flash()->success('Success!', 'Chỉnh sửa đơn vị sở hữu bản quyền thành công.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $content_owner = ContentOwner::findOrFail($id);
        $content_owner->user->delete();
        $provinces = Province::all();

        flash()->success('Success!', 'Xóa đơn vị sở hữu bản quyền thành công.');

        return view('content_owners.index', compact('provinces'));
    }

    public function getDistricts(Request $request)
    {
        $districts = District::where('province_id', $request->province_id)->get();

        return response()->json(['data' => $districts, 'msg' => "Success"], 200);
    }

    public function datatables(Request $request)
    {
        return $this->contentOwnerRepository->getDatatables($request);
    }
}
