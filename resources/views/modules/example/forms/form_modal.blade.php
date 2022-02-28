<div class="modal-header">
    <h4 class="modal-title" id="modal-default-label">Form Tambah</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
</div>
<div class="modal-body">
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
    <form action="{{ url("example/save",[$example?->id ?? 0]) }}" method="POST" enctype="multipart/form-data" id="form_validation">

        <div class="row mb-3">
            <label for="input_name" class="col-sm-12 col-md-12 col-form-label">Name</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="input_name" class="form-control" id="input_name" minlength="6" value="{{$example?->name}}" required >
            </div>
        </div>
        <div class="row mb-3">
            <label for="input_description" class="col-sm-12 col-md-12 col-form-label">Deskripsi</label>
            <div class="col-sm-12 col-md-12">
                <textarea name="input_description" id="input_description" class="form-control" rows="3" required>{{$example?->description}}</textarea>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input_birth_date" class="col-sm-12 col-md-12 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="input_birth_date" id="input_birth_date" class="form-control" placeholder="Pilih Tanggal Lahir" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" value="{{$example?->birth_date}}" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input_current_money" class="col-sm-12 col-md-12 col-form-label">Uang Sekarang</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="input_current_money" id="input_current_money" class="form-control" onkeyup="toCurrency(this)" value="{{toCurrency($example?->current_money)}}" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input_job" class="col-sm-12 col-md-12 col-form-label">Pekerjaan Sekarang</label>
            <div class="col-sm-12 col-md-12">
                <div class="d-flex flex-column">
                    <div class="combobox-container">
                        <select name="input_job" class="form-select select2-custom">
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
            <label for="input-hobby" class="col-sm-12 col-md-12 col-form-label">Hobby</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="checkbox-container">
                        @foreach($hobbies as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="input_hobby_{{$key}}" name="input_hobbies[]" value="{{$key}}" {{in_array($key,$example?->hobby ?? []) ? "checked" : ""}}>
                                <label class="form-check-label" for="input_hobby_{{$key}}">{{$value}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="input_status" class="col-sm-12 col-md-12 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="radio-container">
                        @foreach($statuses as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="input_status" id="input-radio-{{$key}}" value="{{$key}}" {{$example?->status == $key ? "checked" : ""}}>
                                <label class="form-check-label" for="input-radio-{{$key}}">{{$value}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input_profile" class="col-sm-12 col-md-12 col-form-label">Profile Image</label>
            <div class="col-sm-12 col-md-12">
                <input class="form-control" name="input_profile" type="file" id="input_profile">
            </div>
        </div>
        @csrf
    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
        <i class="bx bx-x d-block d-sm-none"></i>
        <span class="d-sm-block d-none">Close</span>
    </button>
    <button type="submit" class="btn btn-primary" name="btn-submit" form="form_validation">
        <i class="bx bx-check d-block d-sm-none"></i>
        <span class="d-sm-block d-none">Accept</span>
    </button>
</div>

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
        })
    });
</script>
