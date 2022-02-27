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

{{-- Core Template --}}
<script src="{{asset('assets/js/mazer.js')}}"></script>

{{-- Custom File --}}
<script src="{{asset('assets/js/main.js')}}"></script>

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
    });

    // [https://stackoverflow.com/questions/28948383/how-to-implement-debounce-fn-into-jquery-keyup-event
    // [http://davidwalsh.name/javascript-debounce-function]
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    function openBox(
        /// Url is mandatory
        url ="zeffry.dev",
        {

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

        $.get(url,function(data,status,xhr){
            $(".modal-content").html(data);
        });
    }

    /// Listen modal bootstrap open / close
    /// When modal is open, we binding Select2JS to Modal
    /// When modal is close, we set Select2JS to default again
    function listenModalBootstrap(){
        /// When Modal is open, binding it to ID modal
        $(window).on('shown.bs.modal', function() {
            $('.select2-custom').select2({
                dropdownParent: $('#modal-default'),
            });
        });

        /// When close, make it default again
		$('.modal').each(function() {
            $(this).on('hidden.bs.modal', function() {
                $(".select2-custom").select2({});
            });
        });
    }

    //// Initialize Select2JS when
    function initializeSelect2JS(){

		/// Initialize select2JS
		$(".select2-custom").select2({});
    }

    /// Initialize Jquery Validation Configuration Global
    /// Available Rules Except :
    /// Because this validation already nice built in HTML5
    /// a. required
    /// b. min
    /// c. max
    /// d. minlength
    /// e. maxlength
    /// f. email
    /// g. url
    /// h. number

    /// Available :
    /// 1. rangelength => rangelength : [5 (min), 10 (max)] Input length should be in range 5 - 10.
    /// Example : ABCDE(VALID) || ABCD (NOT VALID because only have 4 length)
    /// 2. range => range : [10 (mix), 20 (max)] Input value should be range 10 - 20.
    /// Example : 5 (NOT VALID) || 15 (VALID)
    /// 3. step => step : 10 Make input value should be multiple of 10.
    /// Example : 5 (NOT VALID) || 50 (VALID)
    /// 3. equalTo => equalTo : "#password" Make input value must be equal with reference input
    /// Example : password_again { equalTo : "#password"}
    /// 4. accept => accept : "image/*, application/pdf" input only can image or pdf.
    /// Example => accept : "image/*, application/pdf"

    /// Additional Method Jquery usefull [https://github.com/jquery-validation/jquery-validation/tree/master/src/additional]
    function initializeJqueryValidation(){
        $.validator.setDefaults({
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );

                if ( element.prop( "type" ) === "checkbox" ) {
                    element.closest('.checkbox-container').after(error);
                } else if(element.prop("type") === "radio"){
                    element.closest('.radio-container').after(error);
                } else if (element.hasClass('select2-custom')) {
                    element.closest(".combobox-container").after(error);
                } else {
                    error.insertAfter( element );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                if($(element).prop("type") === "checkbox" || $(element).prop("type") === "radio" ){
                    /// Do Nothing, because wan't change color checkbox/radio when valid/invalid
                }else if($(element).hasClass("select2-custom")){
                    $(element).closest(".combobox-container").find('.select2-selection--single').addClass("is-invalid").removeClass("is-valid");
                }else{
                    $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                if($(element).prop("type") === "checkbox" || $(element).prop("type") === "radio" ){
                    /// Do Nothing, because wan't change color checkbox/radio when valid/invalid
                }else if($(element).hasClass("select2-custom")){
                    $(element).closest(".combobox-container").find('.select2-selection--single').addClass("is-valid").removeClass("is-invalid");
                }else{
                    $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
                }
            }
        });
    }

    function initializeDatatableConfiguration(){
        $.extend(true,$.fn.dataTable.defaults,{
            /// [f] = Filter
            /// [l] = show record [10/20/50/100]
            /// [r] = Tulisan processing
            /// [t] = table
            /// [i] = showing 1 to 2 of 2 entries
            /// [p] = Pagination
            dom:
                "<'row mb-3'<'col-sm-12'tr>>" +
                "<'row mb-3'<'d-flex flex-row' <l> <'flex-grow-1 align-self-center'<'d-flex flex-row justify-content-center'i>> <p>>>",
            language: {
            /// Change label on dropdown length 10 | 50 | 100
                lengthMenu: "_MENU_"
            }
        });
    }
</script>
