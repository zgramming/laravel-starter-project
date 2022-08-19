<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">{{ empty($group) ? "Form Tambah" : "Form Update" }}</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i
                class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form action="{{ url("setting/access-menu/save",[$group?->id ?? 0]) }}" method="POST" enctype="multipart/form-data"
          id="form_validation">

        <div class="row mb-3">
            <label for="code" class="col-sm-12 col-md-12 col-form-label">Kode</label>
            <div class="col-sm-12 col-md-12">
                <p>{{ $group?->code ?? '' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <label for="name" class="col-sm-12 col-md-12 col-form-label">Nama</label>
            <div class="col-sm-12 col-md-12">
                <p>{{ $group?->name ?? '' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            @foreach($moduls as $key => $modul)
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-content">
                            <div class="card-body">
                                <h1 class="card-title fw-bold mb-3">{{ $modul->name }}</h1>
                                @if(!empty($modul->menus))
                                    <ul class="list-group">
                                        @foreach($modul->menus as $menu)
                                            @if(!empty($menu->route))
                                                @php
                                                    $nameMenu = $menu->name;
                                                    if($menu->app_menu_id_parent){
                                                        $indukMenu = $modul->menus
                                                            ->filter(fn($value,$key)=> $value->id == $menu->app_menu_id_parent)
                                                            ->first()
                                                            ->name;
                                                        $nameMenu = "$indukMenu > $nameMenu";
                                                    }

                                                    $myAuthorization = $currentAuthorization[$menu->id] ?? [];
                                                @endphp
                                                <li class="list-group-item">
                                                    <div class="d-flex flex-column">
                                                        <h6>{{ ucfirst($nameMenu) }}</h6>
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach(\App\Constant\Constant::LIST_AVAILABLE_ACCESS as $key => $access)
                                                                <li class="d-inline-block m-2">
                                                                    <div class="form-check">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="form-check-input form-check-primary"
                                                                                   name="access_{{$menu->id}}[]"
                                                                                   id="access_{{$menu->id}}_{{$access}}"
                                                                                   value="{{ $access }}"
                                                                                   onclick="accessOnClick(this)"
                                                                                   {{ in_array($access,$myAuthorization) ? "checked" : "" }}>
                                                                            <label class="form-check-label" for="access_{{$menu->id}}_{{$access}}">{{ ucfirst($access) }}</label>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
    $(document).ready(function (e) {
        $("#form_validation").validate({
            rules: {},
            messages: {}
        });

        $('#form_validation').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            if (!form.valid()) return false;

            let data = new FormData(form[0]);
            let url = `{{ url("setting/access-menu/save",[$group?->id ?? 0]) }}`;
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    let modal = $("#modal-default");
                    modal.modal('hide');
                    location.reload();
                }
            }).fail(function (xhr, textStatus) {
                console.log("XHR Fail Console", xhr);
                let errors = xhr.responseJSON?.errors ?? xhr.responseJSON?.message ?? "Terjadi masalah, coba beberapa saat lagi";
                showErrorsOnModal(errors);
            }).done(function (xhr, textStatus) {
                console.log("done : ", xhr);
            });
        })
    });

    function accessOnClick(elem){
        const id = $(elem).attr("id");
        [name, menuId, access] = id.split("_");

        const inputName = `input[name='${name}_${menuId}[]']`;
        const checkedAccess = $(`${inputName}:checked`).val();
        const isHaveViewAccess = checkedAccess.includes("view");

        // if(access === "view"){
        //     alert("access view");
        // }else{
        //     alert("access another view");
        // }

    }
</script>
