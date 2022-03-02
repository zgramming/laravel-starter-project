<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">Export Data</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
    <ul class="list-group mt-3 container-list-group"></ul>
</div>
<div class="modal-body">
    <form action="{{ url("widget/export") }}" method="POST" enctype="multipart/form-data" id="form_validation">
        <div class="row mb-3">
            <label for="input_type_export" class="col-sm-12 col-md-12 col-form-label">Tipe File</label>
            <div class="col-sm-12 col-md-12">
                <div class="d-flex flex-column">
                    <div class="combobox-container">
                        <select name="input_type_export" class="form-select select2-custom" required>
                            <option value="">Pilih Tipe</option>
                            @foreach($types as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
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
    <button type="submit" class="btn btn-primary btn-submit" name="btn-submit" id="btn-submit" form="form_validation">
        <span class="d-sm-block d-none">Export</span>
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
            let isValid = $(this).valid();
            if (!isValid) return false;

            const form = $(this);
            let data = new FormData(form[0]);
            let url = `{{ url("widget/export") }}`;

            let totalResponseLength = 0;
            $.ajax({
                url : url,
                method : 'POST',
                data : data,
                processData: false,
                contentType: false,
                beforeSend : function(){
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
                        if(result.kode === "prepare_folder") $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-prepare-file">${result.message}</li>`)
                        if(result.kode === "read_row"){
                            $(".progress-read-row").remove();
                            $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-read-row">${result.message}</li>`)
                        }
                        if(result.kode === "prepare_download") $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-prepare-download">${result.message}</li>`)
                        if(result.kode === "done"){
                            $(".container-list-group").append(`<li class="list-group-item list-group-item-success progress-remove-file">${result.message}</li>`);
                            window.open(result.file.url,"_blank");
                        }
                    },false);
                    return xhr;
                },
                success :function(data){
                    console.log("Data : ",data);
                },
            }).fail(function(xhr,textStatus){
                console.log("Failll",xhr);
                $(".btn-submit").attr('disabled',false);
                let errors = xhr.responseJSON.errors;
                showErrorsOnModal(errors);
            }).done(function(xhr,textStatus){
                $(".btn-submit").attr('disabled',false);
                console.log("done : ",xhr)
            });
        })
    });
</script>
