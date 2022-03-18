@php
    /// Get Modul where has menu
        $moduls = \App\Models\Modul::with('menus')->whereHas('menus')->get();

@endphp

<style>
    #header-template {
        margin-left: 300px;
    }

    .navbar {
        height: auto !important;
    }

    .modul-item {
        font-size: 14pt;
    }

    .modul-item a {
        color: #7c8db5;
    }

    .modul-item.active > a {
        border-bottom: 2px solid #435ebe;
        color: #435ebe;
        font-weight: bold;
    }

    @media screen and (max-width: 1200px) {
        #header-template {
            margin-left: 0;
        }
    }
</style>
<div class="card">
    <div class="card-content card-body">
        <div class="d-flex flex-wrap flex-row-reverse align-items-center">
            @foreach($moduls as $key => $value)
                <span class="modul-item {{ request()->is($value->pattern) ? "active" : "" }} mx-2 my-2">
                    <a href="{{ url($value->menus->first()->route) }}">{{ $value->name }}</a>
                </span>
            @endforeach
            {{--            <span class="modul-item active mx-2 p-2"><a href="#">Setting</a></span>--}}
            {{--            <span class="modul-item mx-2 p-2"><a href="#">Produksi</a></span>--}}
        </div>
    </div>
</div>
