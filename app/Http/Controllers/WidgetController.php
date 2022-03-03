<?php

namespace App\Http\Controllers;

use App\Models\Example;

use ExportFileType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Throwable;

class WidgetController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function view_document(): Factory|View|Application
    {
        $get = request()->all();
        $keys = $get;
        $extension = strtolower(pathinfo($get['documentUrl'] ?? "https://zeffry.dev/test_document.pdf", PATHINFO_EXTENSION));
        $keys['extension'] = $extension;

        $keys['fullUrl'] = $extension == "pdf" ? asset('assets/js/third_party/pdfjs/web/viewer.html?file='.$get['documentUrl']) : "https://view.officeapps.live.com/op/embed.aspx?src=".$get['documentUrl'];
        return view('widgets.view_document_widget',$keys);
    }

    /**
     * @return Factory|View|Application
     */
    public function view_image(): Factory|View|Application
    {
        $get = request()->all();
        $keys = $get;

        return view('widgets.view_image_widget',$keys);
    }

    /**
     * @return Factory|View|Application
     */
    public function form_export(): Factory|View|Application
    {

        $keys = request()->all();
        $keys['types'] = array(
            ExportFileType::XLSX->value => "XLSX",
            ExportFileType::CSV->value => "CSV",
        );

        return view('widgets.export_widget',$keys);
    }

    /**
     * @return Factory|View|Application
     */
    public function form_import(): Factory|View|Application
    {
        $keys = request()->all();
        return view('widgets.import_widget',$keys);
    }

    /**
     * @return JsonResponse
     */
    public function export(): JsonResponse
    {
        try {
            $post = request()->all();
            $rules = [
                'input_type_export' => "required"
            ];

            $validator = Validator::make($post,$rules);
            if($validator->fails()) return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ], 400);

            $exportedFile = exportSpout(
                header: ['id',
                    'name',
                    'description',
                    'job_desk',
                    'birth_date',
                    'current_money',
                    'profile_image',
                    'hobby',
                    'status'],
                values:Example::all(),
                callback: function($item){
                    return [
                        $item?->id ?? '',
                        $item?->name ?? '',
                        $item?->description ?? '',
                        $item?->job_desk ?? '',
                        $item?->birth_date ?? '',
                        $item?->current_money ?? '',
                        $item?->profile_image ?? '',
                        implode(",",$item?->hobby) ?? '',
                        $item?->status ?? '',
                    ];
                },
                type: ExportFileType::from($post['input_type_export'])
            );

            $message = "Berhasil export data";
            return response()->json(
                [
                    'message'=>$message,
                    'success'=> true,
                    'file' => $exportedFile ?? '',
                    'kode'=>'done',
                ]
                ,200);


        }catch (Throwable $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json(['success'=> false,'errors' => $message],$code ?: 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function import(): JsonResponse
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
                'birth_date' => date('Y-m-d',strtotime($item[4] ?? null)) ?: null,
                'current_money' => $item[5] ?: null ,
                'profile_image' => $item[6] ?: null,
                'hobby' =>  json_encode(explode(",",$item[7])) ?: null,
                'status' => "active",
            ]);

            $no = 0;
            foreach ($values->chunk(1000) as $chunk){
                $no = $no + count($chunk);
                echoFlush('read_row',"Sedang membaca data ke-$no");
                Example::insert($chunk->toArray());
            }

            $message = "Yess Berhasil Import ".count($values)." Data";
            return response()->json(['success'=>true,'kode'=>"done",'message'=>$message,'total_data'=>count($values)],200);
        }catch (Throwable $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json(['success'=> false,'errors' => $message],$code ?: 400);
        }

    }
}
