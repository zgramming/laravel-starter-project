<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Models\Example;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\DataTables;

class ExampleController extends Controller
{
    public function index(): Factory|View|Application
    {
        $hobbies = [
            'memancing' => 'Memancing',
            'memasak' => 'Memasak',
            'menyanyi' => 'Menyanyi'
        ];

        $statuses = [
            "active" => "Aktif",
            "not_active" => "Tidak Aktif",
            'none' => "Tidak Diketahui"
        ];

        $jobs = [
            1 => "Programmer",
            2 => "Pelawan",
            3 => "Badut"
        ];

        $keys = [
            'hobbies' => $hobbies,
            'statuses' => $statuses,
            'jobs' => $jobs,
        ];

        return view('modules.example.grids.example_grid', $keys);
    }

    /**
     * @return View|Factory|Application|JsonResponse
     * @throws Exception
     */
    public function exampleDatatable(): View|Factory|Application|JsonResponse
    {
        if (!request()->ajax()) return view('error.notfound');

        // Option 1 using chaining method
        //            $datatable =  DataTables::of(Example::all())
        //                ->addIndexColumn()
        //                ->toJson();

        // Option 2 using base condition chaining method
        $values = Example::whereNotNull('id');
        $datatable = DataTables::of($values);
        $datatable = $datatable->addIndexColumn();
        //            If you only want specific column to show
        //            $datatable = $datatable->only(['name','birth_date']);

        //            If you want edit return object
        //            $datatable = $datatable->editColumn('name',fn($item)=>"Nama Aku ".$item->name);

        //            If you want add new column out of return object
        //            $datatable = $datatable->addColumn('action');
        //            $datatable = $datatable->addColumn('print');
        //            $datatable = $datatable->rawColumns(['action','print']);

        $datatable = $datatable->filter(function (Builder $query) {
            /// $request->get('YOUR_KEY') harus ditambahkan pada konfigurasi Datatable [ajax => data]
            $request = request()->all();
            $search = $request['search'] ?? "";
            $status = $request['filter_status'] ?? "";

            if (!empty($search)) {
                $query->where('name', 'like', "%" . $search . "%")
                    ->orWhere('description', 'like', "%" . $search . "%")
                    ->orWhere('current_money', '=', $search);
            }

            if (!empty($status)) $query->where('status', '=', $status);
        });

        $datatable = $datatable->orderColumn('status', function (Builder $query, $order) {
            $query->orderBy('status', $order);
        });

        $datatable = $datatable->addColumn("profile_image", function (Example $item) {
            if ($item?->profile_image == null) return "<span class=\"badge bg-danger\">No Image</span>";
            $imagePath = asset(sprintf("storage/%s/%s", Constant::PATH_IMAGE_EXAMPLE, $item->profile_image));

            return "<a href='#' onclick=\"openImage('$imagePath')\"><img alt='Image error' src='$imagePath' class='img-fluid img-thumbnail' width='100' style=\"min-height: 100px; max-height: 100px;\"></a>";
        });

        $datatable = $datatable->addColumn("status", function (Example $item) {
            if ($item->status == "active") return "<span class=\"badge bg-success\">Aktif</span>";
            if ($item->status == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
            return "<span class=\"badge bg-secondary\">None</span>";
        });

        $datatable = $datatable->addColumn('action', function (Example $item) {
            $url = url('setting/example/update/' . $item->id);
            $urlModal = url('setting/example/update-modal/' . $item->id);
            $urlDelete = url('setting/example/delete/' . $item->id);

            $field = csrf_field();
            $method = method_field('DELETE');
            return "
                <div class='d-flex flex-row'>
                    <button type=\"button\" class=\"btn btn-light-secondary mx-1\"><i class=\"fa fa-search\"></i></button>
                    <a href=\"$url\"  class=\"btn btn-primary mx-1\" ><i class=\"fa fa-edit\"></i></a>
                    <a href=\"#\" class=\"btn btn-primary mx-1\" onclick=\"openBox('$urlModal',{size: 'modal-lg'})\">Modal</a>
                    <form action=\"$urlDelete\" method=\"post\">
                        $field
                        $method
                        <button type=\"submit\" class=\"btn btn-danger mx-1\"><i class=\"fa fa-trash\"></i></button>
                    </form>
                </div>
            ";
        });

        return $datatable->rawColumns(['profile_image', 'status', 'action'])->toJson();
    }

    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function form_page(int $id = 0): View|Factory|Application
    {
        $example = Example::find($id);

        $hobbies = [
            'memancing' => 'Memancing',
            'memasak' => 'Memasak',
            'menyanyi' => 'Menyanyi'
        ];

        $statuses = [
            "active" => "Aktif",
            "not_active" => "Tidak Aktif",
            'none' => "Tidak Diketahui"
        ];

        $jobs = [
            1 => "Programmer",
            2 => "Pelawan",
            3 => "Badut"
        ];

        $keys = [
            'hobbies' => $hobbies,
            'statuses' => $statuses,
            'jobs' => $jobs,
            'example' => $example,
        ];

        return view('modules.example.forms.form_page', $keys);
    }

    /**
     * @param int $id
     * @return Factory|View|Application
     */
    public function form_modal(int $id = 0): Factory|View|Application
    {
        $example = Example::find($id);

        $hobbies = [
            'memancing' => 'Memancing',
            'memasak' => 'Memasak',
            'menyanyi' => 'Menyanyi'
        ];

        $statuses = [
            "active" => "Aktif",
            "not_active" => "Tidak Aktif",
            'none' => "Tidak Diketahui"
        ];

        $jobs = [
            1 => "Programmer",
            2 => "Pelawan",
            3 => "Badut"
        ];

        $keys = [
            'hobbies' => $hobbies,
            'statuses' => $statuses,
            'jobs' => $jobs,
            'example' => $example,
        ];

        return view("modules.example.forms.form_modal", $keys);
    }

    /**
     * @param int $id
     * @return JsonResponse|Redirector|Application|RedirectResponse
     * @throws Throwable
     */
    public function save(int $id = 0): JsonResponse|Redirector|Application|RedirectResponse
    {
        /// Rules Available Usefull
        /// 1. accept                       => "Input should be [yes | on | 1 | true]"
        /// 2. alpha                        => "The field under validation must be entirely alphabetic characters."
        /// 3. alpha_dash                   => "The field under validation may have alpha-numeric characters, as well as dashes and underscores."
        /// 4. alpha_num                    => "The field under validation must be entirely alpha-numeric characters."
        /// 5. array                        => "The field under validation must be a PHP array."
        /// 6. bail                         => "Stop running validation rules for the field after the first validation failure."
        /// 7. between:min,max              => "The field under validation must have a size between the given min and max."
        /// 8. boolean                      => "The field under validation must be able to be cast as a boolean. Accepted input are true, false, 1, 0, "1", and "0"."
        /// 9. confirmed                    => "The field under validation must have a matching field of {field}_confirmation"
        /// 10. date                        => "The field under validation must be a valid, non-relative date according to the strtotime PHP function."
        /// 11. declined                    => "The field under validation must be "no", "off", 0, or false."
        /// 12. different:field             => "The field under validation must have a different value than field."
        /// 13. dimensions                  => "The file under validation must be an image meeting the dimension constraints as specified by the rule's parameters:"
        /// 13.A. Example                   => 'avatar' => 'dimensions:min_width=100,min_height=200'
        ///
        /// 14. email                       => "The field under validation must be formatted as an email address."
        /// 15. file                        => "The field under validation must be a successfully uploaded file."
        /// 16. image                       => "The file under validation must be an image (jpg, jpeg, png, bmp, gif, svg, or webp)."
        /// 17. integer                     => "The field under validation must be an integer."
        /// 18. json                        => "The field under validation must be a valid JSON string."
        /// 19. mimetypes:text/plain        => "The file under validation must match one of the given MIME types:"
        /// 19.A. Example                   => 'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime'
        ///
        /// 20. mimes:foo,bar               => "The file under validation must have a MIME type corresponding to one of the listed extensions."
        /// 20.A. Example                   => 'photo' => 'mimes:jpg,bmp,png'
        ///
        /// 21. nullable                    => "The field under validation may be null."
        /// 22. numeric                     => "The field under validation must be numeric"
        /// 23. required                    => "The field under validation must be present in the input data and not empty. A field is considered "empty" if one of the following conditions are true:"
        /// 24. same:field                  => "The given field must match the field under validation."
        /// 25. string                      => "The field under validation must be a string. If you would like to allow the field to also be null, you should assign the nullable rule to the field."
        /// 26. unique:table,column         => "The field under validation must not exist within the given database table."
        /// 26.A. Example                   => 'email' => 'unique:users,email_address'
        ///
        /// 27. uuid                        => "The field under validation must be a valid RFC 4122 (version 1, 3, 4, or 5) universally unique identifier (UUID)."
        ///

        /// Begin Transaction
        DB::beginTransaction();
        try {
            $example = Example::find($id);
            $post = request()->all();
            /// Unique:NAMA_TABLE,NAMA_COLUMN
            $uniqueCode = ($example == null) ? "unique:" . Constant::TABLE_EXAMPLE . ",code" :  Rule::unique(Constant::TABLE_EXAMPLE, 'code')->using(function (\Illuminate\Database\Query\Builder $query) use ($post, $example) {
                $query->where('code', '=', $post['input_code'])
                    ->where('id', '!=', $example->id);
            });

            $rules = [
                'input_code' => ['required', $uniqueCode],
                'input_name' => 'required',
                'input_description' => 'required',
                'input_birth_date' => 'required',
                'input_current_money' => 'required',
                'input_hobbies' => 'required',
                'input_job' => 'required',
                'input_status' => 'required',
            ];

            if (!empty($post['input_profile'])) $rules['input_profile'] = "file|image";

            $validator = Validator::make($post, $rules);
            if ($validator->fails()) {
                if (!empty($post['form_type'])) return response()->json([
                    'success' => false,
                    'errors' => $validator->messages(),
                ], 400);

                return back()->withErrors($validator->messages())->withInput();
            }

            if (!empty($post['input_profile'])) $nameImage = uploadImage($post['input_profile'], Constant::PATH_IMAGE_EXAMPLE, customName: $example?->profile_image ?? null);

            $data = [
                'code' => $post['input_code'],
                'name' => $post['input_name'],
                'description' => $post['input_description'],
                'birth_date' => $post['input_birth_date'],
                'current_money' => fromCurrency($post['input_current_money']),
                'job_desk' => $post['input_job'],
                'hobby' => $post['input_hobbies'],
                'status' => $post['input_status'],

                /// If Name Image null use profile_image, if profile_image null set default to null
                'profile_image' => $nameImage ?? $example?->profile_image ?? null,
            ];

            /// If you want return boolean
            //$result = Example::updateOrInsert($data,['id'=>$id]);

            /// If you want return object
            $result = Example::updateOrCreate(['id' => $id], $data);
            if (!$result) throw new Exception("Terjadi kesalahan saat proses penyimpanan, lakukan beberapa saat lagi...", 400);

            /// Commit Transaction
            DB::commit();
            if (!empty($post['form_type'])) {
                $message = "Yess Berhasil Insert / Update";
                session()->flash('success', $message);
                return response()->json(['success' => true, 'message' => $message], 200);
            }
            return redirect('setting/example')->with('success', !empty($id) ? "Berhasil update" : "Berhasil membuat");
        } catch (QueryException $e) {
            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            $code = $e->getCode() ?: 500;

            if (!empty($post['form_type'])) return response()->json(['success' => false, 'errors' => $message], $code);
            return back()->withErrors($message)->withInput();
        } catch (Throwable $e) {
            /// Rollback Transaction
            DB::rollBack();

            $message = $e->getMessage();
            $code = $e->getCode() ?: 500;

            if (!empty($post['form_type'])) return response()->json(['success' => false, 'errors' => $message], $code);
            return back()->withErrors($message)->withInput();
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
            $example = Example::findOrFail($id);

            /// Delete
            $isDeleted = $example->deleteOrFail();

            /// Check if this data success deleted && and has file data
            /// If [TRUE] Delete the file

            if ($isDeleted && !empty($example?->profile_image)) {
                $path = public_path($example->profile_image);
                if (file_exists($path)) @unlink($path);
            }

            /// Commit Transaction
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
