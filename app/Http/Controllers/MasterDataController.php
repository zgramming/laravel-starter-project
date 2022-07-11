<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Models\MasterCategory;
use App\Models\MasterData;
use DataTables;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class MasterDataController extends Controller
{
    /**
     * @param string $codeCategory
     * @return Factory|View|Application
     */
    public function index(string $codeCategory = ""): Factory|View|Application
    {
        $keys = [];
        $keys['masterCategory'] = MasterCategory::whereCode($codeCategory)->first();
        return view('modules.settings.master_data.grids.master_data_grid', $keys);
    }

    /**
     * @param string $codeCategory
     * @return View|Factory|Application|JsonResponse
     * @throws Exception
     */
    public function datatable(string $codeCategory = ""): View|Factory|Application|JsonResponse
    {
        if (!request()->ajax()) return view('error.notfound');

        $values = MasterData::with(['masterParent'])->whereMasterCategoryCode($codeCategory);
        $datatable = DataTables::of($values)
            ->addIndexColumn()
            ->filter(function (Builder $query) {
                $search = request()->get('search');
                if (!empty($search)) $query->where('name', 'like', "%$search%");
            })->addColumn('masterParent.name',function(MasterData $item){
                return $item?->masterParent?->name ?? "-";
            })->addColumn('status', function (MasterData $item) {
                if ($item->status == "active") return "<span class=\"badge bg-success\">Aktif</span>";
                if ($item->status == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
                return "<span class=\"badge bg-secondary\">None</span>";
            })->addColumn('action', function (MasterData $item) use ($codeCategory) {
                $urlUpdate = url("setting/master-data/form_modal/$codeCategory/$item->id");
                $urlDelete = url("setting/master-data/delete/$item->id");
                $field = csrf_field();
                $method = method_field('DELETE');
                return "
                <div class='d-flex flex-row'>
                    <a href=\"#\" class=\"btn btn-primary mx-1\" onclick=\"openBox('$urlUpdate',{size : 'modal-lg'})\"><i class='fa fa-edit'></i></a>
                    <form action=\"$urlDelete\" method=\"post\">
                        $field
                        $method
                        <button type=\"submit\" class=\"btn btn-danger mx-1\"><i class=\"fa fa-trash\"></i></button>
                    </form>
                </div>
                ";
            })->rawColumns(['status', 'action']);
        return $datatable->toJson();
    }

    public function form_modal(string $codeCategory, int $id): Factory|View|Application
    {
        $category = MasterCategory::whereCode($codeCategory)->first();
        $master = MasterData::find($id);
        $isHaveParent = !empty($category?->master_category_id) && ($category?->id !== $category?->master_category_id);
        $masterInduk = MasterData::where("master_category_id", $category?->master_category_id)->get();
        $keys = [
            'isHaveParent' => $isHaveParent,
            'category' => $category,
            'masterInduk' => $masterInduk,
            'statuses' => Constant::STATUSKEYVALUE,
            'master' => $master,
            'code' => !empty($id) ? $master->code : generateCodeBasic(Constant::TABLE_MST_DATA, "code", $codeCategory, ['master_category_code' => $codeCategory]),

        ];
        return \view('modules.settings.master_data.forms.form_modal', $keys);
    }

    /**
     * @throws Throwable
     */
    public function save(int $id = 0): JsonResponse
    {
        DB::beginTransaction();

        try {
            $master = MasterData::find($id);
            $post = request()->all();

            $rules = [
                'name' => 'required',
                'code' => 'required',
            ];

            $validator = Validator::make($post, $rules);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->messages(),
                ], 400);
            }

            $data = [
                'master_data_id'=> $post['master_data_id'] ?? null,
                'master_category_id' => $post['master_category_id'],
                'master_category_code' => $post['master_category_code'],
                'name' => $post['name'],
                'code' => $post['code'],
                'description' => $post['description'],
                'status' => $post['status'],
            ];

            for ($i = 1; $i <= 5; $i++) {
                $key = "parameter$i" . "_key";
                $value = "parameter$i" . "_value";
                $data[$key] = $post[$key];
                $data[$value] = $post[$value];
            }

            $result = MasterData::updateOrCreate(['id' => $id], $data);
            if (!$result) throw new Exception("Terjadi kesalahan saat proses penyimpanan, lakukan beberapa saat lagi...", 400);

            /// Commit Transaction
            DB::commit();
            $message = "Yess Berhasil Insert / Update";
            session()->flash('success', $message);
            return response()->json(['success' => true, 'message' => $message], 200);

        } catch (QueryException $e) {
            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            $code = $e->getCode() ?: 500;
            return response()->json(['success' => false, 'errors' => $message], $code);

        } catch (Throwable $e) {
            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            $code = $e->getCode() ?: 500;
            return response()->json(['success' => false, 'errors' => $message], $code);
        }
    }

    /**
     * @throws Throwable
     */
    public function delete(int $id = 0): RedirectResponse
    {
        /// Begin Transactions
        DB::beginTransaction();
        try {
            $master = MasterData::find($id);

            $master->deleteOrFail();

            /// Commit Transaction
            DB::commit();
            return back()->with('success', "Berhasil menghapus master data");

        } catch (QueryException $e) {
            /// Rollback Transaction
            DB::rollBack();
            $message = $e->getMessage();

            return back()->withErrors($message)->withInput();
        } catch (Throwable $e) {
            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            return back()->withErrors($message)->withInput();
        }
    }
}
