<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\ImportedDataUsage;
use Maatwebsite\Excel\Facades\Excel;

class StatisticsController extends Controller
{

    private static $excelFileExtension = array('xls', 'xlsx');

    private static $dataFields = array(
        'ktv_id',
        'date',
        'song_file_name',
        'times'
    );

    public function showImportDataUsagePage()
    {
        return view('statistics.import-data-usage');
    }

    public function importDataUsage(Request $request)
    {

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

                        foreach ($rows as $row) {
                            ImportedDataUsage::create($row);
                        }
                    })->get();
                } else {
                    $result['alert-type'] = 'danger';
                    $result['message'] = 'Định dạng file không đúng, vui lòng chọn file khác!';
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
