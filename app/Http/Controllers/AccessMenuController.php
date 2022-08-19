<?php

namespace App\Http\Controllers;

use App\Models\AccessMenu;
use App\Models\Modul;
use App\Models\UserGroup;
use Carbon\Carbon;
use DataTables;
use DB;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContractEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Throwable;

class AccessMenuController extends Controller
{
    public function index(): Factory|View|Application
    {
        $keys = [];
        return view("modules.settings.access_menu.grids.access_menu_grid", $keys);
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
                $urlUpdate = url("setting/access-menu/form_modal/$item->id");
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
        $keys = [
            /// Get Modul Where AccessModul === $idUserGroup
            'moduls' => $this->getAccessModul($idUserGroup),
            'accessMenu' => AccessMenu::where("app_group_user_id", "=", $idUserGroup)->get()->pluck('app_menu_id')->toArray(),
            'group' => UserGroup::find($idUserGroup),
        ];

        $currentAccessMenu = AccessMenu::whereAppGroupUserId($idUserGroup)->get();
        foreach ($currentAccessMenu as $access){
            $keys['currentAuthorization'][$access->app_menu_id] = $access?->allowed_access ?? null;
        }

        return view("modules.settings.access_menu.forms.form_modal", $keys);
    }

    /**
     * @param int $idUserGroup
     * @return Collection|array
     */
    private function getAccessModul(int $idUserGroup): Collection|array
    {
        return Modul::with(
            [
                'menus' => fn(BuilderContractEloquent $query) => $query
                    ->orderBy("app_menu_id_parent")
                    ->orderBy('name', 'ASC'),
            ]
        )->whereRelation('accessModul', 'app_group_user_id', '=', $idUserGroup)
            ->get();
    }

    /**
     * @param int $idUserGroup
     * @return JsonResponse
     * @throws Throwable
     */
    public function save(int $idUserGroup = 0): JsonResponse
    {

        try {
            /// Begin Transaction
            DB::beginTransaction();

            $post = request()->all();

            /// Truncate Every Update Access Menu
            AccessMenu::where("app_group_user_id", "=", $idUserGroup)->delete();

            $tempArr = [];
            $moduls = $this->getAccessModul($idUserGroup);
            $now = Carbon::now()->toDateTimeString();
            foreach ($moduls as $modul) {
                foreach ($modul->menus as $menu) {
                    $authorization = $post["access_$menu[id]"] ?? [];
                    if (!empty($authorization)) {
                        $tempArr[] = [
                            'id' => Str::uuid(),
                            'app_group_user_id' => $idUserGroup,
                            'app_modul_id' => $modul->id,
                            'app_menu_id' => $menu->id,
                            'allowed_access' => json_encode($authorization),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }
            }

            AccessMenu::insert($tempArr);

            /// Commit Transaction
            DB::commit();

            $message = "Yess Update Akses Menu";
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
