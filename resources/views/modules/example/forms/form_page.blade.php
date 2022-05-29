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
            <li class="breadcrumb-item"><a href="{{url('setting/example')}}">Example</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{(empty($example) ? "Form Tambah" : "Form Update")}}</li>
        </ol>
    </nav>
</div>
<form action="{{ url("setting/example/save",[$example?->id ?? 0]) }}" method="POST" enctype="multipart/form-data" id="form_validation">
    <div class="card">
        <div class="card-content">
            <div class="d-flex flex-row justify-content-end mt-3 me-3">
                <div class="buttons">
                    <a href="{{url('setting/example')}}" class="btn btn-light-secondary"><span class="btn-label"><i class="fa fa-arrow-left"></i></span> Kembali</a>
                    <button type="submit" class="btn btn-success"><span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Simpan</button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-row flex-fill">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible show fade w-100">
                            @foreach($errors->all() as $key => $error)
                                <ul>
                                    <li>{{$error}}</li>
                                </ul>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <div class="row mb-3">
                    <label for="input_code" class="col-sm-12 col-md-2 col-form-label">Kode</label>
                    <div class="col-sm-12 col-md-4">
                        <input type="text" name="input_code" class="form-control" id="input_code" value="{{$example?->code}}" required >
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input_name" class="col-sm-12 col-md-2 col-form-label">Name</label>
                    <div class="col-sm-12 col-md-4">
                        <input class="form-control" id="input_name" minlength="6" name="input_name" required
                               type="text" value="{{$example?->name}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input_description" class="col-sm-12 col-md-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-12 col-md-4">
                        <textarea class="form-control" id="input_description" name="input_description" required rows="3">{{$example?->description}}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input_birth_date" class="col-sm-12 col-md-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-12 col-md-4">
                        <input class="form-control" id="input_birth_date" name="input_birth_date"
                               onblur="if(this.value===''){this.type='text'}"
                               onfocus="(this.type='date')" placeholder="Pilih Tanggal Lahir" required
                               type="text" value="{{$example?->birth_date}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input_current_money" class="col-sm-12 col-md-2 col-form-label">Uang Sekarang</label>
                    <div class="col-sm-12 col-md-4">
                        <input class="form-control" id="input_current_money" name="input_current_money"
                               onkeyup="toCurrency(this)" required
                               type="text" value="{{toCurrency($example?->current_money)}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input_job" class="col-sm-12 col-md-2 col-form-label">Pekerjaan Sekarang</label>
                    <div class="col-sm-12 col-md-4">
                        <div class="d-flex flex-column">
                            <div class="combobox-container">
                                <select class="form-select select2-custom" name="input_job">
                                    <option value="">Pilih Job</option>
                                    @foreach($jobs as $key => $value)
                                        <option value="{{$key}}" {{($example?->job_desk == $key ? "selected" : "")}}>{{$value}}</option>
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
                                        <input class="form-check-input" id="input_hobby_{{$key}}" name="input_hobbies[]"
                                               type="checkbox"
                                               value="{{$key}}" {{in_array($key,$example?->hobby ?? []) ? "checked" : ""}}>
                                        <label class="form-check-label" for="input_hobby_{{$key}}">{{$value}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="input_status" class="col-sm-12 col-md-2 col-form-label">Status</label>
                    <div class="col-sm-12 col-md-10 ">
                        <div class="d-flex flex-column">
                            <div class="radio-container">
                                @foreach($statuses as $key => $value)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="input-radio-{{$key}}" name="input_status"
                                               type="radio"
                                               value="{{$key}}" {{$example?->status == $key ? "checked" : ""}}>
                                        <label class="form-check-label" for="input-radio-{{$key}}">{{$value}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input_profile" class="col-sm-12 col-md-2 col-form-label">Image</label>
                    <div class="col-sm-12 col-md-12 d-flex flex-column">
                        <input class="form-control image-upload-preview" id="input_profile" name="input_profile"
                               type="file">
                        @php($pathImage = sprintf("storage/%s/%s",\App\Constant\Constant::PATH_IMAGE_EXAMPLE,$example?->profile_image))
                        <img alt="Image Error" class="img-fluid img-thumbnail image-upload-preview-item mt-3"
                             style="min-height: 300px; max-height: 1000px;"
                             src="{{ !empty($example?->profile_image) ? asset($pathImage) :  asset(\App\Constant\Constant::PATH_DEFAULT_IMAGE) }}">
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
                "input_current_money" : {
                    range : [100000,999999]
                },
                "input_hobbies[]" : {
                    required: true,
                    minlength: 2
                },
                "input_status" : {
                    required :true,
                },
                "input_job" : {
                    required : true,
                }
            },
            messages : {

            }
        });
    });
</script>
@endsection
