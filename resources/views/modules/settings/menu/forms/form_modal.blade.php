<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label"> {{ $menu == null ? "Form Tambah" : "Form Update"}}</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form action="{{ url("setting/menu/save",[$menu?->id ?? 0]) }}" method="POST" enctype="multipart/form-data" id="form_validation">

        <div class="row mb-3">
            <label for="app_modul_id" class="col-sm-12 col-md-12 col-form-label">Modul</label>
            <div class="col-sm-12 col-md-12">
                <div class="d-flex flex-column">
                    <div class="combobox-container">
                        <select class="form-select select2-custom" name="app_modul_id" id="app_modul_id">
                            <option value="">Pilih Modul</option>
                            @foreach($moduls as $key => $value)
                                <option value="{{$value->id}}" {{($menu?->app_modul_id == $value->id ? "selected" : "")}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="app_menu_id_parent" class="col-sm-12 col-md-12 col-form-label">Menu Utama</label>
            <div class="col-sm-12 col-md-12">
                <div class="d-flex flex-column">
                    <div class="combobox-container">
                        <select class="form-select select2-custom" name="app_menu_id_parent" id="app_menu_id_parent">
                            <option value="">Pilih Menu</option>
                            @foreach($menuParents as $key => $value)
                                <option value="{{$value->id}}" {{($menu?->app_menu_id_parent == $value->id ? "selected" : "")}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="code" class="col-sm-12 col-md-12 col-form-label">Kode</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="code" class="form-control" id="code" value="{{$menu?->code}}" readonly required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="name" class="col-sm-12 col-md-12 col-form-label">Name</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="name" class="form-control" id="name" value="{{$menu?->name}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="route" class="col-sm-12 col-md-12 col-form-label">Route</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="route" class="form-control" id="route" value="{{$menu?->route}}" >
            </div>
        </div>

        <div class="row mb-3">
            <label for="order" class="col-sm-12 col-md-12 col-form-label">Urutan</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="order" class="form-control" id="order" value="{{$menu?->order}}" required >
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="status" class="col-sm-12 col-md-12 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="radio-container">
                        @foreach($statuses as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status-{{$key}}" value="{{$key}}" {{ ($menu?->status ?? 'active') == $key ? "checked" : ""}}>
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
            let url = `{{ url("setting/menu/save",[$menu?->id ?? 0]) }}`;
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
        });

        $("#app_modul_id").on('change',function(e){
            e.preventDefault();
            $.get(`{{ url("ajax/menu/get_menu_by_modul") }}/${this.value || 0}`,function(data){
                let menu = $("#app_menu_id_parent");
                menu.empty();
                console.log("data |",data);
                if(menu.length === 0) return false;
                /// Append to code
                $("#code").val(data.code);
                $("#order").val(data.order);
                /// Append to combo box
                menu.append(`<option value="">Pilih Menu</option>`);
                for (let i = 0; i< data.menu.length; i++){
                    const item = data.menu[i];
                    menu.append(`<option value="${item.id}">${item.name}</option>`);
                }
            });
        });
    });
</script>
