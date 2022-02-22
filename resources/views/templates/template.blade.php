<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include("templates.imports.top_import")
    @yield("extend-css","")

    @include("templates.imports.bot_import")
    @yield("extend-js","")

    <title>@yield('title_header','Default Title')</title>
</head>
<body>
    <div id="app">
        @include('templates.components.sidebar')
        <div id="main">
            <header class="mb-3 ">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <section class="section">
                    @yield('content','Default Content')
                </section>
            </div>
        </div>
    </div>
</body>
<!-- START MODAL BOOTSTRAP -->
<div class="modal fade" id="modal-basic" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="modal-view">


            </div>
        </div>
    </div>
</div>
<!-- END MODAL BOOTSTRAP -->
</html>
