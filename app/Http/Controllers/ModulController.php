<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Models\Modul;
use DataTables;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class ModulController extends Controller
{
    public function index(): Factory|View|Application
    {
        $keys = [];
        return view('modules.settings.modul.grids.modul_grid',$keys);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function datatable(): View|Factory|Application|JsonResponse
    {
        if (!request()->ajax()) return view('error.notfound');

        $values = Modul::whereNotNull('id');
        $datatable = DataTables::of($values)
        ->addIndexColumn()
        ->filter(function(\Illuminate\Database\Eloquent\Builder $query){
            $search = request()->get('search');
            if(!empty($search)){
                $query->where('code','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            }
        })->addColumn('status',function(Modul $item){
            if ($item->status == "active") return "<span class=\"badge bg-success\">Aktif</span>";
            if ($item->status == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
            return "<span class=\"badge bg-secondary\">None</span>";
        })->addColumn('action',function(Modul $item){
            $urlUpdate = url('setting/modul/form_modal/'.$item->id);
            $urlDelete = url('setting/modul/delete/'.$item->id);
            $field = csrf_field();
            $method = method_field('DELETE');
            return   "
                <div class='d-flex flex-row'>
                    <a href=\"#\" class=\"btn btn-primary mx-1\" onclick=\"openBox('$urlUpdate')\"><i class='fa fa-edit'></i></a>
                    <form action=\"$urlDelete\" method=\"post\">
                        $field
                        $method
                        <button type=\"submit\" class=\"btn btn-danger mx-1\"><i class=\"fa fa-trash\"></i></button>
                    </form>
                </div>
            ";
        })->rawColumns(['action','status']);

        return $datatable->toJson();
    }

    public function form_modal(int $id =0): Factory|View|Application
    {
        $keys = [];
        $keys['statuses'] = Constant::STATUSKEYVALUE;
        $keys['modul']  = Modul::find($id);
        $keys['order'] = !empty($id) ? $keys['modul']->order : generateUrutan((new Modul)->getTable(),"order");
        return view("modules.settings.modul.forms.form_modal",$keys);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function save(int $id = 0): JsonResponse
    {

        DB::beginTransaction();

        try {
            $modul = Modul::find($id);
            $post = request()->all();
            $uniqueCode = ($modul == null) ? "unique:".Constant::TABLE_APP_MODUL :  Rule::unique(Constant::TABLE_APP_MODUL,'code')->using(function(Builder $query) use($post,$modul){
                $query->where('code', '=', $post['code'])
                    ->where('id','!=',$modul->id);
            });

            $rules = [
                'name'=> ['required'],
                'code'=> ['required',$uniqueCode],
                'description'=> ['nullable'],
                'pattern'=> ['required'],
                'order'=> ['required'],
                'status'=> ['required'],
            ];

            $validator = Validator::make($post,$rules);
            if($validator->fails()) return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ],400);

            $data = [
                'code'=> $post['code'],
                'name'=> $post['name'],
                'order'=> $post['order'],
                'pattern'=> $post['pattern'],
                'icon_name'=> $post['icon_name'] ?? '',
                'status'=> $post['status'],
            ];

            $result = Modul::updateOrCreate(['id'=> $id],$data);
            if(!$result) throw new Exception("Terjadi kesalahan saat proses penyimpanan, lakukan beberapa saat lagi...",400);
            $message = ($modul==null) ? "Berhasil tambah modul dengan kode $post[code]" : "Berhasil update modul dengan kode $post[code]";
            session()->flash('success',$message);

            /// Commit Transaction
            DB::commit();
            return response()->json(['success'=>true,'message'=> $message]);

        }catch(QueryException $e){

            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            return response()->json(['success'=> false,'errors' => $message],500);
        } catch (Throwable $e){

            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            $code = $e->getCode() ?: 400;
            return response()->json(['success'=> false,'errors' => $message],$code);
        }
    }

    /**
     * @param int $id
     * @return Redirector|Application|RedirectResponse
     * @throws Throwable
     */
    public function delete(int $id = 0): Redirector|Application|RedirectResponse
    {
        DB::beginTransaction();
        try {
            $modul = Modul::findOrFail($id);

            /// Delete
            $modul->deleteOrFail();

            /// Commit Transaction
            DB::commit();
            return redirect('setting/modul')->with('success','Berhasil menghapus data !!!');
        }catch (Throwable $e) {
            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            return back()->withErrors($message)->withInput();
        }
    }
}
