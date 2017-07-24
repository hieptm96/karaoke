<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\ImportedDataUsage;
use Maatwebsite\Excel\Facades\Excel;

class StatisticsController extends Controller
{

    private static $excelFileExtension = array('xls', 'xlsx');

    private static $dataFields = array(
        'ktv_id' => 'ma_ktv',
        'date' => 'thoi_gian',
        'song' => 'ma_bai_hat',
        'times' => 'so_lan_su_dung'
    );

    public function showImportDataUsagePage()
    {
        return view('statistics.import-data-usage');
    }

    public function importDataUsage(Request $request)
    {

        if($request->hasFile('data-usage')){
            $file = $request->file('data-usage');

            if ($this->isExcelFile($file)) {

                // // Move Uploaded File
                // $destinationPath = 'uploads';
                ///$pathFile = $file->move($destinationPath, $file->getClientOriginalName());

                $filePath = $file->getPathName();

                if ($this->checkImportedDataFileFormat($filePath)) {

                    $datas = Excel::load($filePath, function($reader) {
                        $reader->get(static::$dataFields);
                    })->get();

                    foreach ($datas as $key => $data) {
                        $array =  (array) $data;
                        // $insert[] = ['title' => $value->title, 'author' => $value->author,
                        //             'created_at' => date('Y-m-d H:i:s')];
                        // echo $value['thoi_gian'];
                        // echo '<br />';
                        ImportedDataUsage::create($array);
                    }
                } else {
                    echo 'invalid';
                }
            }

            echo '<br>';
            return '1';

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
