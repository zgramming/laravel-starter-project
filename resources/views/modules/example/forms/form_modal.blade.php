{{-- TEMPLATE TINGGAL LANGSUNG COPY AJA !!! --}}

{{--<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">--}}
{{--    <div class="d-flex flex-row justify-content-between align-items-end">--}}
{{--        <h4 class="modal-title" id="modal-default-label">{{ empty($example) ? "Form Tambah" : "Form Update" }}</h4>--}}
{{--        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="modal-body">--}}
    {{--    <form id="form_modal_validation"> --}}
        {{--        @csrf--}}
        {{--    </form>--}}
{{--</div>--}}

{{--<div class="modal-footer">--}}
{{--    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">--}}
{{--        <i class="bx bx-x d-block d-sm-none"></i>--}}
{{--        <span class="d-sm-block d-none">Close</span>--}}
{{--    </button>--}}
{{--    <button type="submit" class="btn btn-primary" name="btn-submit" form="form_modal_validation">--}}
{{--        <i class="bx bx-check d-block d-sm-none"></i>--}}
{{--        <span class="d-sm-block d-none">Submit</span>--}}
{{--    </button>--}}
{{--</div>--}}

{{--<script type="text/javascript">--}}
{{--    $(document).ready(function(e){--}}
{{--        $("#form_modal_validation").validate({--}}
{{--            rules : {--}}
{{--            },--}}
{{--            messages : {--}}
{{--            }--}}
{{--        });--}}

{{--        $('#form_modal_validation').on('submit',function(e){--}}
{{--            e.preventDefault();--}}
{{--            const form = $(this);--}}
{{--            if(!form.valid()) return false;--}}

{{--            let data = new FormData(form[0]);--}}
{{--            let url = `{{ url("setting/example/save",[$example?->id ?? 0]) }}`;--}}
{{--            $.ajax({--}}
{{--                url : url,--}}
{{--                method : 'POST',--}}
{{--                data : data,--}}
{{--                processData: false,--}}
{{--                contentType: false,--}}
{{--                success : function(data){--}}
{{--                    let modal = $("#modal-default");--}}
{{--                    modal.modal('hide');--}}
{{--                    location.reload();--}}
{{--                }--}}
{{--                }).fail(function(xhr,textStatus){--}}
{{--                    console.log("XHR Fail Console", xhr);--}}
{{--                    let errors = xhr.responseJSON?.errors ?? xhr.responseJSON?.message ?? "Terjadi masalah, coba beberapa saat lagi";--}}
{{--                    showErrorsOnModal(errors);--}}
{{--                }).done(function(xhr,textStatus){--}}
{{--                    console.log("done : ",xhr);--}}
{{--                });--}}
{{--        })--}}
{{--    });--}}
{{--</script>--}}

<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }
</style>
<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">Form Tambah</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form id="form_modal_validation">

        <div class="row mb-3">
            <label for="input_code" class="col-sm-12 col-md-12 col-form-label">Kode</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="input_code" class="form-control" id="input_code" value="{{$example?->code}}" required >
            </div>
        </div>

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
                <input type="text" name="input_birth_date" id="input_birth_date" class="form-control" placeholder="Pilih Tanggal Lahir" onfocus="(this.type='date')" onblur="if(this.value===''){this.type='text'}" value="{{$example?->birth_date}}" required>
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
                        <select class="form-select select2-custom" name="input_job" id="input_job">
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
                                <input class="form-check-input" type="radio" name="input_status" id="input-radio-{{$key}}" value="{{$key}}" {{ ($example?->status ?? 'active') == $key ? "checked" : ""}}>
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

        <div class="row mb-3">
            <label for="editor_text" class="col-sm-12 col-md-12 col-form-label">Text Editor</label>
            <div class="col-sm-12 col-md-12">
                <textarea name="editor_text" id="editor_text" class="form-control">{!! $example?->editor_text !!}</textarea>
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
    <button type="submit" class="btn btn-primary" name="btn-submit" form="form_modal_validation">
        <i class="bx bx-check d-block d-sm-none"></i>
        <span class="d-sm-block d-none">Accept</span>
    </button>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        ClassicEditor.create(document.querySelector("#editor_text")).catch((error) => {
            console.error(error)
        })
        $("#form_modal_validation").validate({
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

        $('#form_modal_validation').on('submit',function(e){
            e.preventDefault();
            const form = $(this);
            if(!form.valid()) return false;

            let data = new FormData(form[0]);
            data.append('form_type','modal');

            let url = `{{ url("setting/example/save",[$example?->id ?? 0]) }}`;
            $.ajax({
                url : url,
                method : 'POST',
                data : data,
                processData: false,
                contentType: false,
                success : function(data){
                    let modal = $("#modal-default");
                    modal.modal('hide');
                    location.reload();
                }
            }).fail(function(xhr,textStatus){
                console.log("XHR Fail Console", xhr);
                let errors = xhr.responseJSON?.errors ?? xhr.responseJSON?.message ?? "Terjadi masalah, coba beberapa saat lagi";
                showErrorsOnModal(errors);
            }).done(function(xhr,textStatus){
                console.log("done : ",xhr);
            });
        })

    });
</script>


