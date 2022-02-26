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
            <div class="card-header">
                <b>Table DataTable</b>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-filter mb-3">
                        <div class="row">

                            <div class="col-sm-12 col-md-4 mb-sm-3">
                                <div class="d-flex flex-row">
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control" placeholder="Cari berdasarkan..." >
                                        <div class="form-control-icon">
                                            <i class="bi bi-search"></i>
                                        </div>
                                    </div>
                                    <div class="mx-2">
                                        <button type="button" class="btn btn-light toggle-more-filter"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-8 mb-sm-3">
                                <div class="form-group">
                                    <div class="d-flex flex-row justify-content-md-end justify-content-sm-start ">
                                        <div class="buttons">
                                            <a href="{{url('example/create')}}" class="btn btn-success"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</a>
                                            <a href="#" class="btn btn-success" onclick="openBox('{{url('example/create-modal')}}')"><span class="btn-label"><i class="fa fa-plus"></i></span> Popup</a>
                                            <a href="" class="btn btn-info"><span class="btn-label"><i class="fa fa-file-excel"></i></span> Export</a>
                                            <a href="" class="btn btn-dark"><span class="btn-label"><i class="fa fa-file-upload"></i></span> Import</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 toggle-more-filter-content">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <select name="testing_selectbox" class="choices form-select">
                                            <option value="square">Square</option>
                                            <option value="rectangle">Rectangle</option>
                                            <option value="rombo">Rombo</option>
                                            <option value="romboid">Romboid</option>
                                            <option value="trapeze">Trapeze</option>
                                            <option value="traible">Triangle</option>
                                            <option value="polygon">Polygon</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table" style="width: 100%" id="table-datatable">
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
                                <th style="min-width: 200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>

                            </tfoot>
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
        let jqueryDatatable = $("#table-datatable").DataTable({
            processing: true,
            serverSide: true,
            // [https://www.itsolutionstuff.com/post/laravel-datatables-filter-with-dropdown-exampleexample.html]
            ajax: {
                url : url,
                data: function(d){
                    d.search = $('#search').val();
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
                {data: 'created_at'},
                {data: 'updated_at'},
                {data: 'action',orderable:false, searchable:false},
            ],
            /// Untuk menambahkan style pada TD, lakukan disini
            /// [https://github.com/yajra/laravel-datatables/issues/456]
            createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:eq(9)').attr('style','text-align:center; vertical-align:middle;');
            },
            /// [f] = Filter
            /// [l] = show record [10/20/50/100]
            /// [r] = Tulisan processing
            /// [t] = table
            /// [i] = showing 1 to 2 of 2 entries
            /// [p] = Pagination
            dom:
                "<'row mb-3'<'col-sm-12'tr>>" +
                "<'row mb-3'<'d-flex flex-row' <l> <'flex-grow-1 align-self-center'<'d-flex flex-row justify-content-center'i>> <p>>>",
            language: {
            /// Change label on dropdown length 10 | 50 | 100
                lengthMenu: "_MENU_"
            }
        });

        $("#search").keyup(debounce(function (){
            jqueryDatatable.draw();
        },500));
    });
</script>

@endsection
