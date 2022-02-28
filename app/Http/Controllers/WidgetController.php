<?php

namespace App\Http\Controllers;

use App\Models\Example;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function form_export(){

    }

    public function form_import(){

    }

    /**
     * @throws IOException
     */
    public function export(){
    $path = storage_path('/app/public/export/export_spout.xlsx');
        exportSpout($path,
            header: ['id','Nama Aku','Deskripsi','Uang Saya'],
            values:Example::all(),
            callback: function($item){
                return [
                    $item?->id ?? '',
                    $item?->name ?? '',
                    $item?->description ?? '',
                    $item?->current_money ?? '',
                ];
        } );
    }

    /**
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     * @throws IOException
     */
    public function import(){
        $path = storage_path('/app/public/import/testing_spout.xlsx');
        $values = importSpout(path: $path,callback: fn($item) => [
            'name' => $item[1] ?: null,
            'description' => $item[2] ?: null,
            'job_desk' => $item[3] ?: null,
            'birth_date' => Carbon::createFromFormat('d/m/Y',$item[4])->format('Y-m-d') ?: null,
            'current_money' => $item[5] ?: null ,
            'profile_image' => $item[6] ?: null,
            'hobby' =>  json_encode(explode(",",$item[7])) ?: null,
            'status' => $item[8] ?: null,
        ]);

        $result = Example::insert($values);
        dd($result);
    }
}
