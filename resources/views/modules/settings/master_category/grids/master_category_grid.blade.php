@extends('templates.template')
@section('title_header') Master Category @endsection

@section('extends-css')
@endsection

@section('content')
    <div class="d-flex flex-sm-column flex-md-row flex-lg-row justify-content-between my-3">
        <div>
            <h3>Master Kategori</h3>
            <p class="text-subtitle text-muted">Menampilkan semua kategori yang telah dibuat</p>
        </div>
        <nav aria-label="breadcrumb" class="breadcrumb-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('master-category') }}">Master Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav>
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
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 mb-sm-3">
                                    <div class="d-flex flex-row justify-content-md-end justify-content-sm-start ">
                                        <div class="form-group">
                                            <div class="buttons">
                                                <a href="#" class="btn btn-info" onclick="openExport('{{ url('master-category/export') }}')"><span class="btn-label"><i class="fa fa-file-excel"></i></span> Export</a>
                                                <a href="#" class="btn btn-dark" onclick="openImport()"><span class="btn-label"><i class="fa fa-file-upload"></i></span> Import</a>
                                                <a href="#" class="btn btn-success" onclick="openBox('{{url('master-category/create')}}')"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</a>
                                            </div>
                                        </div>
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
                                    <th style="min-width: 200px">Induk</th>
                                    <th style="min-width: 200px">Kode</th>
                                    <th style="min-width: 200px">Nama</th>
                                    <th style="min-width: 200px">Status</th>
                                    <th style="min-width: 200px">Created At</th>
                                    <th style="min-width: 200px">Updated At</th>
                                    <th style="min-width: 50px">Action</th>
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
    <script type="text/javascript">
        $(document).ready(function(e){
            const url = `{{url('master-category-datatable')}}`;
            const jqueryDatatable = $("#table_datatable").DataTable({
                processing: true,
                serverSide: true,
                // [https://www.itsolutionstuff.com/post/laravel-datatables-filter-with-dropdown-exampleexample.html]
                ajax: {
                    url : url,
                    data: function(d){
                        d.search = $('#search').val();
                    },
                },
                columns : [
                    {data: 'DT_RowIndex',orderable :false, searchable : false},
                    {data: 'categoryParent'},
                    {data: 'code'},
                    {data: 'name'},
                    {data: 'status'},
                    {data: 'created_at'},
                    {data: 'updated_at'},
                    {data: 'action'},
                ],
                createdRow: function( row, data, dataIndex ) {
                    // $( row ).find('td:eq(7)').attr('style','text-align:center; vertical-align:middle;');
                },

            });

            $("#search").keyup(debounce(function (){
                jqueryDatatable.draw();
            },500));
        });

    </script>
@endsection
