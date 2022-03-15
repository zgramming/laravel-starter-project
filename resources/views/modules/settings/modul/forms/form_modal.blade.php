<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">{{ ($modul == null) ? "Form Tambah" : "Form Update" }}</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form action="{{ url("setting/modul/save",[$modul?->id ?? 0]) }}" method="POST" enctype="multipart/form-data" id="form_validation">

        <div class="row mb-3">
            <label for="code" class="col-sm-12 col-md-12 col-form-label">Kode</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="code" class="form-control" id="code" value="{{ $modul?->code  }}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="name" class="col-sm-12 col-md-12 col-form-label">Nama</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="name" class="form-control" id="name" value="{{$modul?->name}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="prefix" class="col-sm-12 col-md-12 col-form-label">Pattern</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="pattern" class="form-control" id="pattern" value="{{$modul?->pattern}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="order" class="col-sm-12 col-md-12 col-form-label">Urutan</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="order" class="form-control" id="order" value="{{ $order }}" required >
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="input_status" class="col-sm-12 col-md-12 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="radio-container">
                        @foreach($statuses as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_{{$key}}" value="{{$key}}" {{ ($modul?->status ?? 'active') == $key ? "checked" : ""}}>
                                <label class="form-check-label" for="status_{{$key}}">{{$value}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
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

            let url = `{{ url("setting/modul/save",[$modul?->id ?? 0]) }}`;
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
