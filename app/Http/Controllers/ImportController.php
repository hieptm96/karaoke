<?php

namespace App\Http\Controllers;

use DB;
use Response;
use Datatables;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\ImportedDataUsage;
use Maatwebsite\Excel\Facades\Excel;
use App\Transformers\SongUsageTransformer;

class ImportController extends Controller
{

    private static $excelFileExtension = array('xls', 'xlsx');
    private static $formatFile = '/imports/dataImportformatFile.xls';

    private static $dataFields = array(
        'ktv_id',
        'box_code',
        'date',
        'song_file_name',
        'times'
    );

    public function index()
    {
        return view('statistics.import.index');
    }


    public function importDataUsages(Request $request)
    {
        $downloadImportedFileFormat = '<a class="format-file" href="'. request()->getSchemeAndHttpHost()
            . static::$formatFile . '" target="_blank">Bấm để download định dạng file</a>';

        if($request->hasFile('data-usage')){
            $file = $request->file('data-usage');

            $result = ['alert-type' => 'success', 'message' => 'File đã được ghi nhân vào hệ thống'];

            if ($this->isExcelFile($file)) {
                // // Move Uploaded File
                // $destinationPath = 'uploads';
                ///$pathFile = $file->move($destinationPath, $file->getClientOriginalName());

                $filePath = $file->getPathName();

                if ($this->checkImportedDataFileFormat($filePath)) {

                    $datas = Excel::load($filePath, function($reader) {
                        $rows = $reader->get(static::$dataFields)->toArray();

                        ImportedDataUsage::insert($rows);
                    })->get();
                } else {
                    $result['alert-type'] = 'danger';
                    $result['message'] = 'Định dạng file không đúng, vui lòng chọn file khác!<br>' . $downloadImportedFileFormat;
                }
            } else {
                $result['alert-type'] = 'danger';
                $result['message'] = 'Định dạng file không đúng, vui lòng chọn file khác!';
            }

            return Response::json($result);

        } else {
            return redirect()->back();
        }
    }

    private function isExcelFile($file)
    {
        $fileExtension = $file->getClientOriginalExtension();
        return in_array($fileExtension, static::$excelFileExtension);
    }

    private function checkImportedDataFileFormat($filePath)
    {
        $valid = true;

        $data = Excel::load($filePath, function($reader) use (&$valid) {
            $firstRow = $reader->first()->toArray();

            foreach (static::$dataFields as $field) {
                if ( !isset($firstRow[$field]) ) {
                    $valid = false;
                    break;
                }
            }
        });

        return $valid;
    }
}
