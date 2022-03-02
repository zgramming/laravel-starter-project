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

function initializeDaterangePicker({withTimePicker = false} = {}){
    let momentJsToday = moment();
    let today = momentJsToday.format("MM/DD/YYYY");
    let sevenDayAgo = momentJsToday.subtract(7,'days').format("MM/DD/YYYY");

    let name = "daterangepicker-custom";
    let options = {
        "startDate": sevenDayAgo,
        "endDate": today,
        "maxDate" : today,
    };

    if(withTimePicker){
        options.timePicker = true;
        options.timePicker24Hour = true;
        options.locale = {
            // format : 'MM/DD/YYYY H:mm:ss',
            format : 'MM/DD/YYYY HH:mm',
        };
        name = "daterangetimepicker-custom";
    }

    $("." + name).daterangepicker(options,function(start,end,label){
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });
}

function initializeAjax(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}
