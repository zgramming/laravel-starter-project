<?php

namespace App\Http\Controllers;

use App\Models\Example;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExampleController extends Controller
{
    public function index()
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
            1   => "Programmer",
            2   => "Pelawan",
            3   => "Badut"
        ];

        $keys = [
            'hobbies' => $hobbies,
            'statuses' => $statuses,
            'jobs' => $jobs,
        ];

        return view('modules.example.grids.example_grid', $keys);
    }

    public function exampleDatatable(Request $request)
    {
        if ($request->ajax()) {

            // Option 1 using chaining method
            //            $datatable =  DataTables::of(Example::all())
            //                ->addIndexColumn()
            //                ->toJson();

            // Option 2 using base condition chaining method
            $values = Example::where('id', '!=', null)->latest();
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

            $datatable = $datatable->filter(function (Builder $query) use ($request) {
                /// $request->get('YOUR_KEY') harus ditambahkan pada konfigurasi Datatable [ajax => data]
                $search = $request->get('search');
                $status = $request->get('filter_status');

                if (!empty($search)) {
                    $query->where('name', 'like', "%" . $search . "%")
                        ->orWhere('description', 'like', "%" . $search . "%")
                        ->orWhere('current_money', '=', $search);
                }

                if (!empty($status)) $query->where('status', '=', $status);
            });

            $datatable = $datatable->addColumn("status", function ($item) {
                if ($item == "active") return "<span class=\"badge bg-success\">Aktif</span>";
                if ($item == "not_active") return "<span class=\"badge bg-danger\">Tidak Aktif</span>";
                return "<span class=\"badge bg-secondary\">None</span>";
            });

            $datatable = $datatable->addColumn('action', function ($item) {
                return   "
                        <div class=\"btn-group\" role=\"group\" aria-label=\"Basic example\">
                            <button type=\"button\" class=\"btn btn-light-secondary\"><i class=\"fa fa-search\"></i></button>
                            <button type=\"button\" class=\"btn btn-success\"><i class=\"fa fa-plus\"></i></button>
                            <button type=\"button\" class=\"btn btn-primary\"><i class=\"fa fa-edit\"></i></button>
                            <button type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i></button>
                        </div>
            ";
            });
            $datatable = $datatable->rawColumns(['status', 'action']);
            $datatable = $datatable->toJson();
            return $datatable;
        }

        return view('error.notfound');
    }

    public function form_page(int $id = 0)
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
            1   => "Programmer",
            2   => "Pelawan",
            3   => "Badut"
        ];

        $keys = [
            'hobbies' => $hobbies,
            'statuses' => $statuses,
            'jobs' => $jobs,
        ];

        return view('modules.example.forms.form_page', $keys);
    }

    public function form_modal(int $id = 0)
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
            1   => "Programmer",
            2   => "Pelawan",
            3   => "Badut"
        ];

        $keys = [
            'hobbies' => $hobbies,
            'statuses' => $statuses,
            'jobs' => $jobs,
        ];

        return view("modules.example.forms.form_modal", $keys);
    }
}
