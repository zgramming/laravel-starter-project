<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">{{ ($master == null) ? "Form Tambah" : "Form Update" }}</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form action="{{ url("setting/master-data/save",[$master?->id ?? 0]) }}" method="POST" enctype="multipart/form-data" id="form_validation">
        <input type="hidden" name="master_category_id" value="{{ $category->id }}">
        <input type="hidden" name="master_category_code" value="{{ $category->code }}">

        @if($isHaveParent)
        <div class="row mb-3">
            <label for="input_job" class="col-sm-12 col-md-12 col-form-label">Master Induk</label>
            <div class="col-sm-12 col-md-12">
                <div class="d-flex flex-column">
                    <div class="combobox-container">
                        <select class="form-select select2-custom" name="master_data_id" id="master_data_id">
                            <option value="">Pilih Induk</option>
                            @foreach($masterInduk as $key => $value)
                                <option value="{{$value?->id}}" {{($value?->id == $master?->master_data_id ? "selected" : "")}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row mb-3">
            <label for="code" class="col-sm-12 col-md-12 col-form-label">Kode</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="code" class="form-control" id="code" value="{{$code}}" readonly required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="name" class="col-sm-12 col-md-12 col-form-label">Nama</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="name" class="form-control" id="name" value="{{$master?->name}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="description" class="col-sm-12 col-md-12 col-form-label">Deskripsi</label>
            <div class="col-sm-12 col-md-12">
                <textarea name="description" id="description" class="form-control" rows="3" required>{{$master?->description}}</textarea>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="input_status" class="col-sm-12 col-md-12 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="radio-container">
                        @foreach($statuses as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_{{$key}}" value="{{$key}}" {{ ($master?->status ?? 'active') == $key ? "checked" : ""}}>
                                <label class="form-check-label" for="status_{{$key}}">{{$value}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-3">
        @for($i = 1; $i <=5; $i++)
            @php
                $key ="parameter$i"."_key";
                $value ="parameter$i"."_value";
            @endphp

            <div class="row">
                <div class="col-md-6">
                    <label for="{{ $key }}" class="col-sm-12 col-md-12 col-form-label">Key</label>
                    <div class="col-sm-12 col-md-12">
                        <input type="text" name="{{ $key }}" class="form-control" id="{{ $key }}" value="{{ $master?->$key }}" >
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="{{ $value }}" class="col-sm-12 col-md-12 col-form-label">Value</label>
                    <div class="col-sm-12 col-md-12">
                        <input type="text" name="{{ $value }}" class="form-control" id="{{ $value }}" value="{{$master?->$value}}" >
                    </div>
                </div>
            </div>
        @endfor
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
        <span class="d-sm-block d-none">Submit</span>
    </button>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#form_validation").validate({
            rules : {
            },
            messages : {

            }
        });

        $('#form_validation').on('submit',function(e){
            e.preventDefault();
            const form = $(this);
            if(!form.valid()) return false;

            let data = new FormData(form[0]);
            data.append('form_type','modal');

            let url = `{{ url("setting/master-data/save",[$master?->id ?? 0]) }}`;
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
