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
                    <button type="submit" class="btn btn-success"><span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Simpan</button>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <label for="input-name" class="col-sm-12 col-md-2 col-form-label">Name</label>
                    <div class="col-sm-12 col-md-4">
                        <input type="text" name="input-name" class="form-control" id="input-name" minlength="6" value="" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input-description" class="col-sm-12 col-md-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-12 col-md-4">
                        <textarea name="description" id="input-description" class="form-control" rows="3" minlength="100" required></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input-birth-date" class="col-sm-12 col-md-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-12 col-md-4">
                        <input type="date" name="input-birth-date" id="input-birth-date" class="form-control" value="" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input-current-money" class="col-sm-12 col-md-2 col-form-label">Uang Sekarang</label>
                    <div class="col-sm-12 col-md-4">
                        <input type="text" name="input-current-money" id="input-birth-date" class="form-control" onkeyup="convertCurrency(this)" value="" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input-job" class="col-sm-12 col-md-2 col-form-label">Pekerjaan Sekarang</label>
                    <div class="col-sm-12 col-md-4">
                        <div class="d-flex flex-column">
                            <div class="combobox-container">
                                <select name="input-job" class="form-select select2-custom">
                                    <option value="">Pilih Job</option>
                                    @foreach($jobs as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="input-hobby" class="col-sm-12 col-md-2 col-form-label">Hobby</label>
                    <div class="col-sm-12 col-md-10 ">
                        <div class="d-flex flex-column">
                            <div class="checkbox-container">
                                @foreach($hobbies as $key => $value)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="input-checkbox-{{$key}}" name="hobbies[]" value="{{$key}}">
                                        <label class="form-check-label" for="input-checkbox-{{$key}}">{{$value}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="input-status" class="col-sm-12 col-md-2 col-form-label">Status</label>
                    <div class="col-sm-12 col-md-10 ">
                        <div class="d-flex flex-column">
                            <div class="radio-container">
                                @foreach($statuses as $key => $value)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="input-status" id="input-radio-{{$key}}" value="{{$value}}">
                                        <label class="form-check-label" for="input-radio-{{$key}}">{{$value}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input-profile" class="col-sm-12 col-md-2 col-form-label">Profile Image</label>
                    <div class="col-sm-12 col-md-4">
                        <input class="form-control" name="input-profile" type="file" id="input-profile" required>
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
                "input-current-money" : {
                    range : [100000,999999]
                },
                "hobbies[]" : {
                    required: true,
                    minlength: 2
                },
                "input-status" : {
                    required :true,
                },
                "input-job" : {
                    required : true,
                }
            },
            messages : {

            }
        })
    });
</script>
@endsection
