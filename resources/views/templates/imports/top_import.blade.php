{{-- Font Family --}}
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

{{-- Bootstrap 5 --}}
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-icons/bootstrap-icons.css')}}">

{{-- Scroll --}}
<link rel="stylesheet" href="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">

{{-- Datatable --}}
<link rel="stylesheet" href="{{asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css')}}">

{{-- Select2JS --}}
<link rel="stylesheet" href="{{asset('assets/css/third_party/select2/select2.min.css')}}" />

{{-- Core --}}
<link rel="stylesheet" href="{{asset('assets/css/app.css')}}">

{{-- FavIcon --}}
<link rel="shortcut icon" href="{{asset('assets/images/favicon.svg')}}" type="image/x-icon">

<style>
    .select2-container .select2-selection--single{
        min-height: 40px !important;
        padding: 6px;
        color: red;
    }

    /* Change Border Color */
    .select2-container--default .select2-selection--single{
        border-radius: 5px !important;
        border: 1px solid #dce7f1;
    }

    .select2-container--default .select2-selection--single.is-valid{
        border: 1px solid #198754 !important;
    }
    .select2-container--default .select2-selection--single.is-invalid{
        border: 1px solid #dc3545 !important;
    }

    /* Change Color selected value Select2 */
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        color: #607080;
    }

    span.select2-selection__arrow{
        top: 8px !important;
        right: 8px !important;
    }
</style>
