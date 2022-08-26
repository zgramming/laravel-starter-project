<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class UserGroupController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $keys = [];
        return view('modules.settings.user_group.grids.user_group_grid', $keys);
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
                $urlUpdate = url("setting/user-group/form_modal/$item->id");
                $urlDelete = url("setting/user-group/delete/$item->id");

                $field = csrf_field();
                $method = method_field('DELETE');
                return "
                <div class='d-flex flex-row'>
                    <a href=\"#\" class=\"btn btn-primary mx-1\" onclick=\"openBox('$urlUpdate')\"><i class=\"fa fa-edit\"></i></a>
                    <form action=\"$urlDelete\" method=\"post\">
                        $field
                        $method
                        <button type=\"submit\" class=\"btn btn-danger mx-1\"><i class=\"fa fa-trash\"></i></button>
                    </form>
                </div>
            ";
            })
            ->rawColumns(['status', 'action']);

        return $datatable->toJson();
    }

    /**
     * @param int $id
     * @return Factory|View|Application
     */
    public function form_modal(int $id = 0): Factory|View|Application
    {
        $keys = [];
        $keys['statuses'] = Constant::STATUSKEYVALUE;
        $keys['userGroup'] = UserGroup::find($id);
        return view('modules.settings.user_group.forms.form_modal', $keys);
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
            $userGroup = UserGroup::find($id);

            /// Unique:NAMA_TABLE,NAMA_COLUMN
            $uniqueCode = ($userGroup == null) ? "unique:" . Constant::TABLE_APP_GROUP_USER : Rule::unique(Constant::TABLE_APP_GROUP_USER, 'code')->using(function (\Illuminate\Database\Query\Builder $query) use ($post, $userGroup) {
                $query->where('code', '=', $post['code'])
                    ->where('id', '!=', $userGroup->id);
            });

            $rules = [
                'code' => ['required', $uniqueCode],
                'name' => 'required',
                'status' => 'required'
            ];

            $validator = Validator::make($post, $rules);
            if ($validator->fails()) return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->messages(),
                ],
                400
            );

            $data = [
                'code' => $post['code'],
                'name' => $post['name'],
                'status' => $post['status'],
            ];

            $result = UserGroup::updateOrCreate(['id' => $id], $data);
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
    public function delete(int $id = 0): Redirector|Application|RedirectResponse
    {
        /// Begin Transactions
        DB::beginTransaction();
        try {
            $userGroup = UserGroup::findOrFail($id);

            $userGroup->delete();

            /// Commit Transaction
            DB::commit();
            return redirect('setting/user-group')->with('success', 'Berhasil menghapus data !!!');
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
