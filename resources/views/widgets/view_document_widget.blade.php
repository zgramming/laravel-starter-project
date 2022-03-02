<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">Lihat Dokumen</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
    <ul class="list-group mt-3 container-list-group"></ul>
</div>
<div class="modal-body">
    @if($extension == "pdf")
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info alert-dismissible show fade">
                    <strong>Perhatian!</strong> Jika terdapat masalah dalam preview file PDF, pastikan extension IDM sudah di nonaktifkan atau ikuti cara pada <a href="https://stackoverflow.com/a/30201038/7360353" target="_blank"><b><u>Link</u></b></a> ini

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <div class="mt-3">
        <iframe src="{{ $fullUrl }}" width='100%' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
    </div>
</div>
