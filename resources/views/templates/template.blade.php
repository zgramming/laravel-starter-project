<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" >

    @include("templates.imports.top_import")
    @yield("extends-css","")

    <title>@yield('title_header','Default Title')</title>
</head>
<body>
    <div id="app">
        @include('templates.components.sidebar')
        <div id="main">
            @include("templates.components.header")
            <div class="page-heading">
                <section class="section">
                    @yield('content','Default Content')
                </section>
            </div>
        </div>
    </div>
</body>

<!-- START MODAL BOOTSTRAP -->
@include("templates.components.modal.modal_default")
<!-- END MODAL BOOTSTRAP -->

@include("templates.imports.bot_import")
@yield("extends-js","")
</html>
