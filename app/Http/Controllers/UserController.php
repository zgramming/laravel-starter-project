<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Models\User;
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

class UserController extends Controller
{

    public function index(): Factory|View|Application
    {
        $keys = [];
        return view('modules.settings.user.grids.user_grid', $keys);
    }

    /**
     * @return View|Factory|Application|JsonResponse
     * @throws Exception
     */
    public function datatable(): View|Factory|Application|JsonResponse
    {
        if (!request()->ajax()) return view('error.notfound');

        $values = User::whereNotNull('id');
        $datatable = DataTables::of($values)
            ->addIndexColumn()
            ->filter(function (Builder $query) {
                $request = request()->all();
                $search = $request['search'] ?? "";
                if (!empty($search)) {
                    $query->where('name', 'like', "%" . $search . "%")
                        ->orWhere('email', 'like', "%" . $search . "%");
                }
            })->addColumn("status", function (User $item) {
                if ($item->status == "active") return "<span class=\"badge bg-success\">Aktif</span>";
                if ($item->status == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
                return "<span class=\"badge bg-secondary\">None</span>";
            })->addColumn('action', function (User $item) {
                $urlUpdate = url('setting/user/form_modal/' . $item->id);
                $urlDelete = url('setting/user/delete/' . $item->id);

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
            })->rawColumns(['status', 'action']);

        return $datatable->toJson();
    }

    public function form_modal(int $id = 0): Factory|View|Application
    {
        $keys = [];
        $keys['user'] = User::find($id);
        $keys['userGroups'] = UserGroup::all();
        $keys['statuses'] = Constant::STATUSKEYVALUE;

        return \view('modules.settings.user.forms.form_modal', $keys);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function save(int $id = 0): JsonResponse
    {
        /// Begin Transaction
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $post = request()->all();

            $uniqueUsername = ($user == null) ? "unique:" . Constant::TABLE_APP_USER : Rule::unique(Constant::TABLE_APP_USER, 'username')->using(function (\Illuminate\Database\Query\Builder $query) use ($post, $user) {
                $query->where('username', '=', $post['username'])
                    ->where('id', '!=', $user->id);
            });

            $uniqueEmail = ($user == null) ? "unique:" . Constant::TABLE_APP_USER : Rule::unique(Constant::TABLE_APP_USER, 'email')->using(function (\Illuminate\Database\Query\Builder $query) use ($post, $user) {
                $query->where('email', '=', $post['email'])
                    ->where('id', '!=', $user->id);
            });

            $rules = [
                'app_group_user_id' => ['required'],
                'username' => ['required', $uniqueUsername],
                'name' => ['required'],
                'email' => ['required', $uniqueEmail],
                'password' => ['required'],
                'status' => ['required'],
            ];

            $validator = Validator::make($post, $rules);
            if ($validator->fails()) return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ], 400);

            $data = [
                'app_group_user_id' => $post['app_group_user_id'],
                'name' => $post['name'],
                'username' => $post['username'],
                'password' => $post['password'],
                'email' => $post['email'],
                'status' => $post['status'],
            ];

            $result = User::updateOrCreate(['id' => $id], $data);
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
     * @return Redirector|Application|RedirectResponse
     * @throws Throwable
     */
    public function delete(int $id = 0): Redirector|Application|RedirectResponse
    {
        /// Begin Transactions
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            $user->deleteOrFail();

            /// Commit Transaction
            DB::commit();
            return redirect('setting/user')->with('success', 'Berhasil menghapus data !!!');
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
