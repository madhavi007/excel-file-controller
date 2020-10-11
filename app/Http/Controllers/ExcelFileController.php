<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Validator;

class ExcelFileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('warning', 'Error occured during uploading file!');

            return redirect()
                ->route('dashboard')
                ->withErrors($validator)
                ->withInput();
        }

        $spreadsheet = IOFactory::load($request->file('file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray('', true, true, true);

        try {
            $file_data = new File();
            $file_data->content = json_encode($sheetData);
            $file_data->save();
        } catch (\Exception $e) {
            dd($e);
        }

        $request->session()->flash('success', 'File successfully added!');
        return redirect()->route('dashboard');

    }

    public function fetch(Request $request)
    {

        $datas = File::orderby('Id', 'DESC')->first();
        return response()->json($datas->content);

    }

    public function search(Request $request)
    {

        $datas = File::orderby('Id', 'DESC')->first();
        $select_search = $request['select_key']; //Email
        $search = $request['select_value']; //'abc@a.com';
        $sort_column_name = $request['header_name']; //'Age';
        $sort_column_order = $request['header_order']; //'Desc';
        $d = json_decode($datas->content, true);
        $search_item = array_shift($d);

        $check_search_colmn_key = array_search($select_search, $search_item);
        $check_sort_colmn_key = array_search($sort_column_name, $search_item);

        $array = [];
        $array1 = [];
        array_push($array, $search_item);
        try {
            if ($select_search && $sort_column_name) {
                foreach ($d as $new_d) {
                    if (is_numeric($search)) {
                        $check_search_key = array_search($search, $new_d);
                    } else {
                        $check_search_key = str_contains(strtolower($new_d[$check_search_colmn_key]), strtolower($search));
                    }
                    if ($check_search_key) {
                        array_push($array1, $new_d);
                    }
                }
                $array_sort = collect($array1);
                if ($sort_column_order == 'desc') {
                    $array_sort = $array_sort->sortByDesc($sort_column_name)->toArray();
                } else {
                    $array_sort = $array_sort->sortBy($sort_column_name)->toArray();
                }

            } else if ($select_search == null) {
                $array_sort = collect($d);
                if ($sort_column_order == 'desc') {
                    $array_sort = $array_sort->sortByDesc($check_sort_colmn_key)->toArray();
                } else {
                    $array_sort = $array_sort->sortBy($check_sort_colmn_key)->toArray();
                }
            } else {
                foreach ($d as $new_d) {
                    if (is_numeric($search)) {
                        $check_search_key = array_search($search, $new_d);
                    } else {
                        $check_search_key = str_contains(strtolower($new_d[$check_search_colmn_key]), strtolower($search));
                    }
                    if ($check_search_key) {
                        array_push($array1, $new_d);
                    }
                }
                $array_sort = collect($array1)->sortBy($select_search)->reverse()->toArray();
            }

            $sort_array = array_merge($array, $array_sort);

            $filter_data = json_encode($sort_array);

            return response()->json($filter_data);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
