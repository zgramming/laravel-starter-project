<?php

namespace App\Http\Controllers;

use App\Models\Example;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Carbon\Carbon;
use PHPUnit\Util\Exception;
use Str;

class WidgetController extends Controller
{
    public function form_export(){

    }

    public function form_import(){
        $keys = [];
        return view('widgets.import_widget',$keys);
    }


    /**
     * @throws InvalidArgumentException
     * @throws IOException
     * @throws WriterNotOpenedException
     */
    public function export(){
    $path = storage_path('/app/public/export/export_spout.xlsx');
        $path = exportSpout($path,
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

    public function import_progress(){
        return Str::random(20);
    }
    public function import(): \Illuminate\Http\JsonResponse
    {
        try {
            $post = request()->all();

            $rules = [
//                'input_import' => 'image'
            ];

            $validator  = \Validator::make($post,$rules);
            if($validator->fails()) return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ], 400);

            $values = importSpout(file:$post['input_import'],callback: fn($item) => [
                'name' => $item[1] ?: null,
                'description' => $item[2] ?: null,
                'job_desk' => $item[3] ?: null,
                'birth_date' => Carbon::createFromFormat('d/m/Y',$item[4])->format('Y-m-d') ?: null,
                'current_money' => $item[5] ?: null ,
                'profile_image' => $item[6] ?: null,
                'hobby' =>  json_encode(explode(",",$item[7])) ?: null,
                'status' => $item[8] ?: null,
            ]);

            Example::insert($values);
            $message = "Yess Berhasil Import ".count($values)." Data";
            session()->flash('success',$message);
            return response()->json(['success'=>true,'kode'=>"done",'message'=>$message,'total_data'=>count($values)],200);
        }catch (\Throwable $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json(['success'=> false,'errors' => $message],$code ?: 400);
        }

    }
}
