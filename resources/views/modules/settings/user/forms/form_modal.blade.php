<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">{{ empty($user) ? "Form Tambah" : "Form Update" }}</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form action="{{ url("setting/user/save",[$user?->id ?? 0]) }}" method="POST" enctype="multipart/form-data" id="form_validation">

        <div class="row mb-3">
            <label for="app_group_user_id" class="col-sm-12 col-md-12 col-form-label">Grup</label>
            <div class="col-sm-12 col-md-12">
                <div class="d-flex flex-column">
                    <div class="combobox-container">
                        <select class="form-select select2-custom" name="app_group_user_id" id="app_group_user_id" required>
                            <option value="">Pilih Grup</option>
                            @foreach($userGroups as $key => $value)
                                <option value="{{$value->id}}" {{($user?->app_group_user_id == $value->id ? "selected" : "")}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="name" class="col-sm-12 col-md-12 col-form-label">Nama</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="name" class="form-control" id="name" value="{{$user?->name}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-sm-12 col-md-12 col-form-label">Email</label>
            <div class="col-sm-12 col-md-12">
                <input type="email" name="email" class="form-control" id="email" value="{{$user?->email}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="username" class="col-sm-12 col-md-12 col-form-label">Username</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="username" class="form-control" id="username" value="{{$user?->username}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-sm-12 col-md-12 col-form-label">Password</label>
            <div class="col-sm-12 col-md-12">
                <input type="password" name="password" class="form-control" id="password" value="{{$user?->password}}" required >
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="status" class="col-sm-12 col-md-12 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="radio-container">
                        @foreach($statuses as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status-{{$key}}" value="{{$key}}" {{ ($user?->status ?? 'active') == $key ? "checked" : ""}}>
                                <label class="form-check-label" for="status-{{$key}}">{{$value}}</label>
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
            let url = `{{ url("setting/user/save",[$user?->id ?? 0]) }}`;
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
