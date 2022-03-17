<?php

namespace App\Http\Controllers;

use App\Models\AccessModul;
use App\Models\Modul;
use App\Models\UserGroup;
use DataTables;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Throwable;

class AccessModulController extends Controller
{
    public function index(): Factory|View|Application
    {
        $keys = [];
        return view("modules.settings.access_modul.grids.access_modul_grid", $keys);
    }

    /**
     * @return Application|Factory|View|JsonResponse
     * @throws Exception
     */
    public function datatable(): Application|Factory|View|JsonResponse
    {
        if (!request()->ajax()) return view('error.notfound');
        $values = UserGroup::whereNotNull('id');

        $datatable = DataTables::of($values)
            ->addIndexColumn()
            ->filter(function (Builder $query) {
                $request = request()->all();
                $search = $request['search'];

                if (!empty($search)) $query->where("code", "like", "%$search%")
                    ->orWhere("name", "like", "%$search%");
            })
            ->addColumn("status", function (UserGroup $item) {
                if ($item->status == "active") return "<span class=\"badge bg-success\">Aktif</span>";
                if ($item->status == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
                return "<span class=\"badge bg-secondary\">None</span>";
            })
            ->addColumn("action", function (UserGroup $item) {
                $urlUpdate = url("setting/access-modul/form_modal/$item->id");
                return "
                <div class='d-flex flex-row'>
                    <a href=\"#\" class=\"btn btn-primary mx-1\" onclick=\"openBox('$urlUpdate',{size : 'modal-lg'})\"><i class=\"fa fa-edit\"></i></a>
                </div>
            ";
            })
            ->rawColumns(['status', 'action']);

        return $datatable->toJson();
    }

    /**
     * @param int $idUserGroup
     * @return Factory|View|Application
     */
    public function form_modal(int $idUserGroup = 0): Factory|View|Application
    {
        $moduls = Modul::all();

        $keys = [];
        $keys['group'] = UserGroup::find($idUserGroup);
        $keys['moduls'] = $moduls;
        $keys['idModuls'] = AccessModul::where("app_group_user_id", "=", $idUserGroup)->pluck('app_modul_id')->toArray();
        return view("modules.settings.access_modul.forms.form_modal", $keys);
    }

    /**
     * @param int $idUserGroup
     * @return JsonResponse
     * @throws Throwable
     */
    public function save(int $idUserGroup = 0): JsonResponse
    {

        /// Begin Transaction
        DB::beginTransaction();
        try {
            $post = request()->all();

            /// Truncate Every Update Access Modul
            AccessModul::whereNotNull('id')->delete();

            foreach (($post['access_modul'] ?? []) as $key => $value){
                $data = [
                    'id'=> Str::uuid(),
                    'app_group_user_id'=> $idUserGroup,
                    'app_modul_id'=> $value,
                ];

                AccessModul::create($data);
            }

            /// Commit Transaction
            DB::commit();

            $message = "Yess Update Akses Modul";
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
}
