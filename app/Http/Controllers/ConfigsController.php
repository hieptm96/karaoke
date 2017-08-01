<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Config;
use App\Http\Requests\ConfigRequest;

class ConfigsController extends Controller
{
    public function index()
    {
        $data = Config::orderBy('updated_at', 'desc')->first();
        $id = $data->id;
        $config = json_decode($data->config, true);
        return view('configs.index', compact('config', 'id'));
    }

    public function update(ConfigRequest $request, $id)
    {
        $data = Config::findOrFail($id);

        $config = array(
            'price' => str_replace('.', '', $request->price),
            'singer_rate' => $request->singer_rate,
            'musician_rate' => $request->musician_rate,
            'title_rate' => $request->title_rate,
            'film_rate' => $request->film_rate
        );
        $data->update([
            'config' => json_encode($config),
            'updated_by' => Auth::id()
        ]);

        flash()->success('Success!', 'Cập nhật cấu hình thành công.');

        return redirect()->back();
    }
}
