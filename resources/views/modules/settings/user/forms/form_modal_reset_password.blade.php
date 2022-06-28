<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">Reset Password</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i
                class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form method="POST" enctype="multipart/form-data"
          id="form_validation">

        <div class="row mb-3">
            <label for="password" class="col-sm-12 col-md-12 col-form-label">Password Baru</label>
            <div class="col-sm-12 col-md-12">
                <input type="password" name="new_password" class="form-control" id="new_password" value=""
                       required>
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
            let url = `{{ url("setting/user/reset_password",[$row?->id ?? 0]) }}`;
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
</script>
