<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">Import Data</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
    <ul class="list-group mt-3 container-list-group"></ul>
    @if($urlFunctionImport == null)
        <div class="alert alert-warning alert-dismissible show fade w-100">
            <span>Fungsi import belum di setup, akan menggunakan default import</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<div class="modal-body">
    <form action="{{ url("widget/import") }}" method="POST" enctype="multipart/form-data" id="form_validation">
        <div class="row mb-3">
            <label for="input_import" class="col-sm-12 col-md-12 col-form-label">File Import</label>
            <div class="col-sm-12 col-md-12">
                <input class="form-control" name="input_import" type="file" id="input_import" required>
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
    <button type="submit" class="btn btn-primary btn-submit" name="btn-submit" id="btn-submit" form="form_validation">
        <span class="d-sm-block d-none">Import</span>
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

            let isValid = $(this).valid();
            if (!isValid) return false;

            const form = $(this);
            let data = new FormData(form[0]);
            let url = `{{ $urlFunctionImport ?? url("widget/import") }}`;

            let totalResponseLength = 0;
            /// [https://stackoverflow.com/questions/42838609/how-to-flush-php-output-buffer-properly]
            $.ajax({
                url : url,
                method : 'POST',
                data : data,
                processData: false,
                contentType: false,
                beforeSend : function(){
                    /// Before trigger ajax, we should empty [.container-list-group] && Disabled button && Hide Error modal if exists
                    hideErrorsOnModal();
                    $(".container-list-group").empty();
                    $(".btn-submit").attr('disabled',true);
                },
                xhr : function(){
                    const xhr = new window.XMLHttpRequest();
                    xhr.addEventListener('progress',function(e){
                        /// Get current response of response
                        let currentResponse = e.currentTarget.responseText.substr(totalResponseLength);
                        totalResponseLength = e.currentTarget.responseText.length;
                        /// Check if response is json, if [true] we parse it
                        const result = IsJsonString(currentResponse) ? JSON.parse(currentResponse) : "";
                        console.log("current response",result);
                        /// Check if response is error, if [true] show error on modal then stop operation
                        if(!result.success && IsJsonString(result)) {
                            showErrorsOnModal(result.errors);
                            return false;
                        }
                        /// Check if [kode] matches with condition
                        /// If [true] Append component depend of the progress [kode]
                        if(result.kode === "prepare_file") $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-prepare-file">${result.message}</li>`)
                        if(result.kode === "load_file") $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-load-file">${result.message}</li>`)
                        if(result.kode === "read_row"){
                            $(".progress-read-row").remove();
                            $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-read-row">${result.message}</li>`)
                        }
                        if(result.kode === "remove_file") $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-remove-file">${result.message}</li>`)
                        if(result.kode === "done") $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-remove-file">${result.message}</li>`);
                    },false);
                    return xhr;
                },
                success : function(data){
                    let modal = $("#modal-default");
                    // modal.modal('hide');
                    // location.reload();
                }
            }).fail(function(xhr,textStatus){
                console.log("XHR Fail Console", xhr);
                $(".btn-submit").attr('disabled',false);
                let errors = xhr.responseJSON?.errors ?? xhr.responseJSON?.message ?? "Terjadi masalah, coba beberapa saat lagi";
                showErrorsOnModal(errors);
            }).done(function(xhr,textStatus){
                console.log("done : ",xhr);
            });

        });
    });
</script>
