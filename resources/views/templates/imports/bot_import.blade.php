{{-- Jquery --}}
<script src="{{asset('assets/vendors/jquery/jquery.min.js')}}"></script>

{{-- Scroll JS --}}
<script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

{{-- DataTable --}}
<script src="{{asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js')}}"></script>

{{-- Font Awesome 5 --}}
<script src="{{asset('assets/vendors/fontawesome/all.min.js')}}"></script>

{{-- Jquery Validation --}}
<script src="{{asset('assets/js/third_party/jquery_validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/js/third_party/jquery_validation/additional-methods.js')}}"></script>
<script src="{{asset('assets/js/third_party/jquery_validation/override-core-method.js')}}"></script>
<script src="{{asset('assets/js/third_party/jquery_validation/extends-method.js')}}"></script>

{{-- Select2JS --}}
<script src="{{asset('assets/js/third_party/select2/select2.min.js')}}"></script>

{{-- MomentJS --}}
<script src="{{asset('assets/js/third_party/momentjs/momentjs.js')}}"></script>

{{-- Daterange Picker --}}
<script src="{{asset('assets/js/third_party/daterangepicker/daterangepicker.js')}}"></script>

{{-- Core Template --}}
<script src="{{asset('assets/js/mazer.js')}}"></script>

{{-- Custom File --}}
<script src="{{asset('assets/js/custom/main.js')}}"></script>
<script src="{{asset('assets/js/custom/initialization.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function(e){
        /// Initialize Select2JS
        initializeSelect2JS();

        /// Initialize Jquery Validation Configuration
        initializeJqueryValidation();

        /// initialize Datatable default configuration
        initializeDatatableConfiguration();

        /// Listen Modal Bootstrap Open / Close
        listenModalBootstrap();

        /// Initialize Daterange Picker
        initializeDaterangePicker();

        /// Initialize Daterange Timepicker
        initializeDaterangePicker({withTimePicker : true});

        /// Initialize AJAX when perform POST/DELETE/PUT/PATCH using AJAX
        initializeAjax();

        /// Set Default Toggle Filter Content to hidden
        $(".toggle-more-filter-content").hide();

        $(".toggle-more-filter").on('click',function(e){
            let child = $(this).children();
            let isPlusIcon = child.hasClass('fa-plus');
            if(isPlusIcon)  child.removeClass('fa-plus').addClass('fa-minus');
            else child.removeClass('fa-minus').addClass('fa-plus');

            /// Toggle Filter Content
            $(".toggle-more-filter-content").toggle('fast');
        });

        /// Image Preview on change
        $('.image-upload-preview-item').on("error",function(e){
            $(this).attr('src',"{{ asset('assets/images/samples/broken-image.png') }}");
        })

        $(".image-upload-preview").on('change',function(e){
            e.preventDefault();
            if(this.files && this.files[0]){
                let reader = new FileReader();
                reader.onload = function(x){
                    $(".image-upload-preview-item").attr('src',x.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    function openImage(imageUrl){
        openBox(`{{ url('widget/view-image') }}`,{
            parameter : {
                imageUrl : imageUrl,
            },
            modalScrollable : false,
        });
    }

    function openDocument(documentUrl){
        openBox(`{{ url('widget/view-document') }}`,{
            parameter : {
                documentUrl : documentUrl,
            },
            size : "modal-xl",
        });
    }

    function openImport(urlFunctionImport = ""){
        openBox(`{{ url('widget/import') }}`,{
            parameter : {urlFunctionImport : urlFunctionImport},
        });
    }

    function openExport(urlFunctionExport = ""){
        openBox(`{{ url('widget/export') }}`,{
            parameter : {urlFunctionExport : urlFunctionExport}
        });
    }

    function openBox(url ="zeffry.dev",
                     {
                    /// Parameter to passed into modal
                    parameter  = {},

                    /// [modal-sm, modal-md, modal-lg, modal-xl, modal-full]
                    size = "",

                    /// Make modal header dont have border bottom
                    borderlessModal = false,

                    /// Make modal center of screen
                    verticalCentered = true,

                    /// Make body of modal scrollable if content is long
                    modalScrollable = true,

        } = {}){
        let modal = $("#modal-default");
        let modalDialog = modal.children();

        if(borderlessModal) modal.addClass('modal-borderless');

        if(size.length !== 0 ) modalDialog.addClass(size);

        if(verticalCentered) modalDialog.addClass('modal-dialog-centered');

        if(modalScrollable) modalDialog.addClass('modal-dialog-scrollable');

        /// Open Modal
        modal.modal('show');

        $.ajax({
            url : url,
            method : "GET",
            data : parameter,
            beforeSend : function(xhr, data){

            },
            success : function(data,textStatus,xhr){
                $(".modal-content").html(data);
            }
        }).fail(function(xhr,status,error){
            console.log(xhr,status,error);
            alert(xhr.responseJSON.message);
            modal.modal('hide');
        });
    }

</script>
