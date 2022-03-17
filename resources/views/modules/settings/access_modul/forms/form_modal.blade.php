<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">{{ empty($group) ? "Form Tambah" : "Form Update" }}</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form action="{{ url("setting/access-modul/save",[$group?->id ?? 0]) }}" method="POST" enctype="multipart/form-data" id="form_validation">

        <div class="row mb-3">
            <label for="code" class="col-sm-12 col-md-12 col-form-label">Kode</label>
            <div class="col-sm-12 col-md-12">
                <p>{{ $group?->code ?? '' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <label for="name" class="col-sm-12 col-md-12 col-form-label">Kode</label>
            <div class="col-sm-12 col-md-12">
                <p>{{ $group?->name ?? '' }}</p>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="" class="col-sm-12 col-md-12 col-form-label">Akses Modul</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="checkbox-container">
                        @foreach($moduls as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="input_hobby_{{$key}}" name="access_modul[]" value="{{ $value->id }}" {{in_array($value->id,$idModuls ?? []) ? "checked" : ""}}>
                                <label class="form-check-label" for="input_hobby_{{$key}}">{{$value->name}}</label>
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
    $(document).ready(function(e){
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
            let url = `{{ url("setting/access-modul/save",[$group?->id ?? 0]) }}`;
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
