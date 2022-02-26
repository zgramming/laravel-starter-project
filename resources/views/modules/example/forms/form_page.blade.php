@extends('templates.template')
@section('title_header') Halaman User @endsection

@section('extends-css')
@endsection

@section('content')
<div class="d-flex flex-sm-column flex-md-row flex-lg-row justify-content-between my-3">
    <div>
        <h3>Form Example</h3>
    </div>
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('example')}}">Example</a></li>
            <li class="breadcrumb-item active" aria-current="page">Form Tambah</li>
        </ol>
    </nav>
</div>

<form action="{{url('example/create')}}" method="POST" enctype="multipart/form-data" id="form_validation">
    <div class="card">
        <div class="card-content">
            <div class="d-flex flex-row justify-content-end mt-3 me-3">
                <div class="buttons">
                    <a href="{{url('example')}}" class="btn btn-light"><span class="btn-label"><i class="fa fa-arrow-left"></i></span> Kembali</a>
                    <button type="submit" class="btn btn-success"><span class="btn-label"><i class="fa fa-save"></i></span> Simpan</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nama Lengkap</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="name" class="form-control" name="name" placeholder="Nama Lengkap" minlength="3" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Uang Sekarang</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="current_money" class="form-control" name="current_money" placeholder="Uang Sekarang" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-sm-12 col-md-6 align-self-center">
                        <label for="birth_date_label">Tanggal Lahir</label>
                        <input type="date" id="birth_date_label" class="form-control" placeholder="Tanggal Lahir" name="birth_date" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
            			<input type="file" id="file1" name="file1" class="form-control" accept="image/x-eps,application/pdf">
                    </div>
                </div>

            </div>
        </div>
    </div>
    @csrf
</form>
@endsection

@section('extends-js')
<script type="text/javascript">
    $(document).ready(function(){
        $("#form_validation").validate({
            rules : {
                current_money : {
                    range : [10000, 25000]
                }
            },
            messages : {
                file1 : {
                    accept : "Hanya boleh file PDF"
                }
            }
            // messages : {},
        })
    });
</script>
@endsection
