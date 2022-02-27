<div class="modal-header">
    <h4 class="modal-title" id="modal-default-label">Form Tambah</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
</div>
<div class="modal-body">
    <form action="{{url('example/create')}}" method="POST" enctype="multipart/form-data" id="form_validation">

        <div class="row mb-3">
            <label for="input-name" class="col-sm-12 col-md-12 col-form-label">Name</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="input-name" class="form-control" id="input-name" minlength="6" value="" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-description" class="col-sm-12 col-md-12 col-form-label">Deskripsi</label>
            <div class="col-sm-12 col-md-12">
                <textarea name="description" id="input-description" class="form-control" rows="3" minlength="100" required></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-birth-date" class="col-sm-12 col-md-12 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-12 col-md-12">
                <input type="date" name="input-birth-date" id="input-birth-date" class="form-control" value="" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-current-money" class="col-sm-12 col-md-12 col-form-label">Uang Sekarang</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="input-current-money" id="input-current-money" class="form-control" onkeyup="convertCurrency(this)" value="" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-job" class="col-sm-12 col-md-12 col-form-label">Pekerjaan Sekarang</label>
            <div class="col-sm-12 col-md-12">
                <div class="d-flex flex-column">
                    <div class="combobox-container">
                        <select name="input-job" class="form-select select2-custom">
                            <option value="">Pilih Job</option>
                            @foreach($jobs as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="input-hobby" class="col-sm-12 col-md-12 col-form-label">Hobby</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="checkbox-container">
                        @foreach($hobbies as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="input-checkbox-{{$key}}" name="hobbies[]" value="{{$key}}">
                                <label class="form-check-label" for="input-checkbox-{{$key}}">{{$value}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="input-status" class="col-sm-12 col-md-12 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="radio-container">
                        @foreach($statuses as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="input-status" id="input-radio-{{$key}}" value="{{$value}}">
                                <label class="form-check-label" for="input-radio-{{$key}}">{{$value}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-profile" class="col-sm-12 col-md-12 col-form-label">Profile Image</label>
            <div class="col-sm-12 col-md-12">
                <input class="form-control" name="input-profile" type="file" id="input-profile" required>
            </div>
        </div>

    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
        <i class="bx bx-x d-block d-sm-none"></i>
        <span class="d-sm-block d-none">Close</span>
    </button>
    <button type="submit" class="btn btn-primary" name="btn-submit" form="form_validation">
        <i class="bx bx-check d-block d-sm-none"></i>
        <span class="d-sm-block d-none">Accept</span>
    </button>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#form_validation").validate({
            rules : {
                "input-current-money" : {
                    range : [100000,999999]
                },
                "hobbies[]" : {
                    required: true,
                    minlength: 2
                },
                "input-status" : {
                    required :true,
                },
                "input-job" : {
                    required : true,
                }
            },
            messages : {

            }
        })
    });
</script>
