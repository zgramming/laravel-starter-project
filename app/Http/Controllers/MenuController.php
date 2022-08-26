<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Models\Menu;
use App\Models\Modul;
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
use Illuminate\Support\Facades\Validator;
use Throwable;

class MenuController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $keys = [];

        $keys['moduls'] = Modul::all();
        return view('modules.settings.menu.grids.menu_grid', $keys);
    }

    /**
     * @return View|Factory|Application|JsonResponse
     * @throws Exception
     */
    public function datatable(): View|Factory|Application|JsonResponse
    {
        if (!request()->ajax()) return view('error.notfound');

        $values = Menu::with('modul', 'menuParent')->whereNotNull('id');
        $datatable = DataTables::of($values)
            ->addIndexColumn()
            ->filter(function (Builder $query) {
                $request = request()->all();
                $search = $request['search'];
                $modul = $request['modul'];

                if (!empty($search)) $query->where('name', 'like', "%$search%");
                if (!empty($modul)) $query->where('app_modul_id', '=', $modul);
            })->addColumn('status', function (Menu $item) {
                if ($item->status == "active") return "<span class=\"badge bg-success\">Aktif</span>";
                if ($item->status == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
                return "<span class=\"badge bg-secondary\">None</span>";
            })->editColumn('menuParent.id', function (Menu $item) {
                if (empty($item->menuParent)) return "-";
                return $item->menuParent->name;
            })->addColumn('action', function (Menu $item) {
                $urlUpdate = url("setting/menu/form_modal/$item->id");
                $urlDelete = url("setting/menu/delete/$item->id");
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

    /**
     * @param int $id
     * @return Factory|View|Application
     */
    public function form_modal(int $id = 0): Factory|View|Application
    {
        $keys = [];
        $keys['menu'] = Menu::find($id);
        $keys['statuses'] = Constant::STATUSKEYVALUE;
        $keys['moduls'] = Modul::all();
        $keys['menuParents'] = Menu::where('app_modul_id', "=", $keys['menu']?->app_modul_id)->where('id', '!=', $id)->get();
        return view('modules.settings.menu.forms.form_modal', $keys);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function save(int $id = 0): JsonResponse
    {

        try {
            DB::beginTransaction();

            $post = request()->all();
            $rules = [
                'app_modul_id' => 'required',
                'code' => 'required',
                'name' => 'required',
                'order' => 'required',
                'status' => 'required'
            ];

            $validator = Validator::make($post, $rules);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->messages(),
                ], 400);
            }

            $data = [
                'app_modul_id' => $post['app_modul_id'],
                'app_menu_id_parent' => $post['app_menu_id_parent'] ?? null,
                'code' => $post['code'],
                'name' => $post['name'],
                'route' => $post['route'] ?? null,
                'order' => $post['order'],
                'icon_name' => $post['icon_name'] ?? null,
                'status' => $post['status'],
            ];

            $result = Menu::updateOrCreate(['id' => $id], $data);
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
     * @param int $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function delete(int $id = 0): RedirectResponse
    {
        try {
            $menu = Menu::findOrFail($id);

            $menu->deleteOrFail();
            /// Commit Transaction
            DB::commit();
            return back()->with('success', "Berhasil menghapus menu");
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

    /**
     * Ajax Section
     */

    /**
     * @param int $idModul
     * @return JsonResponse
     */
    public function getMenuByModul(int $idModul = 0): JsonResponse
    {
        $returnEmpty = response()->json(['success' => true, 'data' => null], 200);
        if (!request()->ajax()) return $returnEmpty;

        $menu = Menu::whereAppModulId($idModul)->get();
        if (empty($menu)) return $returnEmpty;

        $modul = Modul::find($idModul);
        $codeMenu = generateCodeBasic((new Menu)->getTable(), 'code', $modul->code, ['app_modul_id' => $modul->id]);
        $order = generateUrutan((new Menu)->getTable(), "order", ['app_modul_id' => $modul->id]);
        return response()->json(
            [
                'success' => true,
                'menu' => $menu,
                'code' => $codeMenu,
                'order' => $order,
            ],
            200
        );
    }
}
