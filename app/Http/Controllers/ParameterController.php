<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Models\Parameter;
use DataTables;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder as BuilderEloquent;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class ParameterController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $keys = [];
        return view('modules.settings.parameter.grids.parameter_grid', $keys);
    }

    /**
     * @return View|Factory|Application|JsonResponse
     * @throws Exception
     */
    public function datatable(): View|Factory|Application|JsonResponse
    {
        if (!request()->ajax()) return view('error.notfound');

        $values = Parameter::whereNotNull('id');
        $datatable = DataTables::of($values)
            ->addIndexColumn()
            ->filter(function (BuilderEloquent $query) {
                $request = request()->all();
                $search = $request['search'] ?? "";

                if (!empty($search)) $query->where('name', 'like', "%" . $search . "%")
                    ->orWhere('value', 'like', "%" . $search . "%");
            })
            ->addColumn("status", function (Parameter $item) {
                if ($item->status == "active") return "<span class=\"badge bg-success\">Aktif</span>";
                if ($item->status == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
                return "<span class=\"badge bg-secondary\">None</span>";
            })
            ->addColumn('action', function (Parameter $item) {
                $urlForm = url('setting/parameter/form_modal/' . $item->id);
                $urlDelete = url('setting/parameter/delete/' . $item->id);

                $field = csrf_field();
                $method = method_field('DELETE');
                return "
                <div class='d-flex flex-row'>
                    <a href=\"#\" class=\"btn btn-primary mx-1\" onclick=\"openBox('$urlForm')\"><i class=\"fa fa-edit\"></i></a>
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
        $keys['parameter'] = Parameter::find($id);
        $keys['statuses'] = Constant::STATUSKEYVALUE;
        return view('modules.settings.parameter.forms.form_modal', $keys);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function save(int $id = 0): JsonResponse
    {
        try {
            $parameter = Parameter::find($id);
            $post = request()->all();
            /// Unique:NAMA_TABLE,NAMA_COLUMN
            $uniqueCode = ($parameter == null) ? "unique:" . Constant::TABLE_PARAMETER . ",code" : Rule::unique(Constant::TABLE_PARAMETER, 'code')->using(function (Builder $query) use ($post, $parameter) {
                $query->where('code', '=', $post['code'])
                    ->where('id', '!=', $parameter->id);
            });

            $rules = [
                'name' => ['required'],
                'code' => ['required', $uniqueCode],
                'value' => ['required'],
                'status' => ['required'],
            ];

            $validator = Validator::make($post, $rules);
            if ($validator->fails()) return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ], 400);

            $data = [
                'name' => $post['name'],
                'code' => $post['code'],
                'value' => $post['value'],
                'status' => $post['status'],
            ];

            $result = Parameter::updateOrCreate(['id' => $id], $data);
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
        // Begin Transactions
        DB::beginTransaction();
        try {
            $parameter = Parameter::findOrFail($id);

            /// Delete
            $parameter->deleteOrFail();

            DB::commit();
            return redirect('setting/example')->with('success', 'Berhasil menghapus data !!!');
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
