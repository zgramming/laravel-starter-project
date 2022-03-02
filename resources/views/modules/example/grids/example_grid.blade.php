@extends('templates.template')
@section('title_header') Halaman User @endsection

@section('extends-css')
@endsection

@section('content')
    <div class="d-flex flex-sm-column flex-md-row flex-lg-row justify-content-between my-3">
        <div>
            <h3>Halaman Example</h3>
            <p class="text-subtitle text-muted">Halaman untuk dokumentasi developer</p>
        </div>
        <nav aria-label="breadcrumb" class="breadcrumb-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dokumentasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contoh</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>Table Standar</b>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table" style="width: 100%">
                                <thead>
                                <tr>
                                    <th style="min-width: 50px">No</th>
                                    <th style="min-width: 200px">Nama</th>
                                    <th style="min-width: 200px">Deskripsi</th>
                                    <th style="min-width: 200px">Birth Date</th>
                                    <th style="min-width: 200px">Current Money</th>
                                    <th style="min-width: 200px">Profile Image</th>
                                    <th style="min-width: 200px">Hobby</th>
                                    <th style="min-width: 200px">Created At</th>
                                    <th style="min-width: 200px">Updated At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=1; $i<=20; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                                </tbody>
                                <tfoot></tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content mt-3">
                    <div class="card-body">
                        <div class="table-filter mb-3">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="d-flex flex-row">
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan..." >
                                            <div class="form-control-icon">
                                                <i class="bi bi-search"></i>
                                            </div>
                                        </div>
                                        <div class="form-group mx-2">
                                            <select name="filter_job" id="filter_job" class="form-select select2-custom">
                                                <option value="">Pilih Job</option>
                                                @foreach($jobs as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mx-2">
                                            <select name="filter_hobbies" id="filter_hobbies" class="form-select select2-custom">
                                                <option value="">Pilih Hobby</option>
                                                @foreach($hobbies as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mx-2">
                                            <button type="button" class="btn btn-light-secondary toggle-more-filter"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 mb-sm-3">
                                    <div class="d-flex flex-row justify-content-md-end justify-content-sm-start ">
                                        <div class="form-group">
                                            <div class="buttons">
                                                <a href="#" class="btn btn-warning" onclick="openImage('{{ asset(Storage::url('images/example/621cd8c786a7e1646057671.jpg')) }}')"><span class="btn-label"><i class="fa fa-search"></i></span> Gambar</a>
                                                <a href="#"
                                                   class="btn btn-danger"
                                                   onclick="openDocument('{{ asset(Storage::url('temp/docs/document.docx')) }}')">
                                                    <span class="btn-label"><i class="fa fa-search"></i></span> Document
                                                </a>
                                                <a href="#" class="btn btn-info" onclick="openExport()"><span class="btn-label"><i class="fa fa-file-excel"></i></span> Export</a>
                                                <a href="#" class="btn btn-dark" onclick="openImport()"><span class="btn-label"><i class="fa fa-file-upload"></i></span> Import</a>
                                                <a href="#" class="btn btn-success" onclick="openBox('{{url('example/create-modal')}}',{size: 'modal-lg'})"><span class="btn-label"><i class="fa fa-plus"></i></span> Popup</a>
                                                <a href="{{url('example/create')}}" class="btn btn-success"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <div class="toggle-more-filter-content">
                                        <fieldset>
                                            <legend>Filter Lainnya</legend>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <select name="filter_status" id="filter_status" class="form-select select2-custom" style="width: 100%;">
                                                            <option value="">Pilih Status</option>
                                                            @foreach($statuses as $key => $value)
                                                                <option value="{{$key}}">{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" name="filter_birth_date" id="filter_birth_date" class="form-control" placeholder="Tanggal Lahir" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" name="filter_daterangepicker" id="filter_daterangepicker" class="form-control daterangepicker-custom">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" name="filter_daterangetimepicker" id="filter_daterangetimepicker" class="form-control daterangetimepicker-custom">
                                                    </div>
                                                </div>

                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @include('templates.components.messages.errors.witherrors',['errors' => $errors])
                                @include('templates.components.messages.success.withsuccess',['message' => $message = Session::get('success')])
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%" id="table_datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width: 50px">No</th>
                                        <th style="min-width: 200px">Nama</th>
                                        <th style="min-width: 200px">Deskripsi</th>
                                        <th style="min-width: 200px">Birth Date</th>
                                        <th style="min-width: 200px">Current Money</th>
                                        <th style="min-width: 200px">Profile Image</th>
                                        <th style="min-width: 200px">Hobby</th>
                                        <th style="min-width: 100px">Status</th>
                                        <th style="min-width: 200px">Created At</th>
                                        <th style="min-width: 200px">Updated At</th>
                                        <th style="min-width: 200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extends-js')

<script>
    $(document).ready(function(e){
        let url = `{{url('example-datatable')}}`;
        let jqueryDatatable = $("#table_datatable").DataTable({
            processing: true,
            serverSide: true,
            // [https://www.itsolutionstuff.com/post/laravel-datatables-filter-with-dropdown-exampleexample.html]
            ajax: {
                url : url,
                data: function(d){
                    d.search = $('#search').val();
                    d.filter_status = $("#filter_status").val();
                    // Lakukan seperti ini untuk dropdown / checkbox / radio dll.
                    // d.radio = $("#radioku").val();
                },
            },
            columns : [
                {data: 'DT_RowIndex',orderable :false, searchable : false},
                {data: 'name'},
                {data: 'description'},
                {data: 'birth_date'},
                {data: 'current_money'},
                {data: 'profile_image'},
                {data: 'hobby'},
                {data: 'status'},
                {data: 'created_at'},
                {data: 'updated_at'},
                {data: 'action',orderable:false, searchable:false},
            ],
            /// Untuk menambahkan style pada TD, lakukan disini
            /// [https://github.com/yajra/laravel-datatables/issues/456]
            createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:eq(7)').attr('style','text-align:center; vertical-align:middle;');
                $( row ).find('td:eq(9)').attr('style','text-align:center; vertical-align:middle;');
            },

        });

        $("#search").keyup(debounce(function (){
            jqueryDatatable.draw();
        },500));

        $("#filter_status").on('change',function(e){
            e.preventDefault();
            jqueryDatatable.draw();
        })
    });
</script>

@endsection
