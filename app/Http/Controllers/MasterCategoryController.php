<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Models\MasterCategory;
use DataTables;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class MasterCategoryController extends Controller
{

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $keys = [];
        return view('modules.settings.master_category.grids.master_category_grid',$keys);
    }

    /**
     * @return View|Factory|Application|JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function datatable(): View|Factory|Application|JsonResponse
    {
        if (!request()->ajax()) return view('error.notfound');

        $values = MasterCategory::whereNotNull('id');
        $datatable = DataTables::of($values)
            ->addIndexColumn()
            ->filter(function(Builder $query){
                $search = request()->get('search');
                if(!empty($search)){
                    $query->where('code','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
                }
            })->orderColumn('categoryParent',function(Builder $query,$order){
                $query->orderBy('master_category_id',$order);
            })->addColumn('status',function(MasterCategory $item){
                if ($item->status == "active") return "<span class=\"badge bg-success\">Aktif</span>";
                if ($item->status == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
                return "<span class=\"badge bg-secondary\">None</span>";
            })->addColumn('categoryParent',function(MasterCategory $item){
                return $item->categoryParent?->name ?? "-";
            })->addColumn('action',function(MasterCategory $item){
                $urlUpdate = url('master-category/update/'.$item->code);
                $urlDelete = url('master-category/delete/'.$item->id);
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
            })->rawColumns(['categoryParent','status','action']);

        return $datatable->toJson();
    }

    public function form_modal(string $codeCategory = "")
    {
        $keys = [];

        $keys['statuses'] = Constant::STATUSKEYVALUE;
        $keys['masterCategory'] = MasterCategory::whereCode($codeCategory)->first();
        $keys['masterCategoryParents'] = MasterCategory::all();
        return view('modules.settings.master_category.forms.master_category_form_modal',$keys);
    }

    /**
     * @throws Throwable
     */
    public function save(int $id = 0): JsonResponse
    {
        DB::beginTransaction();
        try{
            $category = MasterCategory::find($id);
            $post = request()->all();

            $uniqueCode = $category == null ? "unique:master_category" :  Rule::unique('master_category','code')->using(function($query) use($post,$category){
                $query->where('code', '=', $post['code'])
                    ->where('id','!=',$category->id);
            });

            $rules = [
                'mst_category_id' => ['nullable'],
                'name'=> ['required'],
                'code'=> ['required',$uniqueCode],
                'description'=> ['nullable'],
                'status'=> ['required'],
            ];

            $validator = Validator::make($post,$rules);
            if($validator->fails()) return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ],400);

            $data = [
                'master_category_id'=> $post['mst_category_id'],
                'name'=> $post['name'],
                'code'=> $post['code'],
                'description'=> $post['description'],
                'status'=> $post['status'],
            ];

            $result = MasterCategory::updateOrCreate(['id'=> $id],$data);
            if(!$result) throw new Exception("Terjadi kesalahan saat proses penyimpanan, lakukan beberapa saat lagi...",400);
            $message = ($category==null) ? "Berhasil tambah kategori dengan kode $post[code]" : "Berhasil update kategori dengan kode $post[code]";
            session()->flash('success',$message);

            /// Commit Transaction
            DB::commit();
            return response()->json(['success'=>true,'message'=> $message],200);

        } catch(QueryException $e){

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

/// Begin Transactions
        DB::beginTransaction();
        try {
            $category = MasterCategory::findOrFail($id);

            /// Delete
            $category->deleteOrFail();

            /// Commit Transaction
            DB::commit();
            return redirect('master-category')->with('success','Berhasil menghapus data !!!');
        }catch (Throwable $e) {
            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            $code = $e->getCode();
            return back()->withErrors($message)->withInput();
        }
    }
}
