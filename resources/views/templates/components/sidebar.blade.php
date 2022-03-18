@php
    use App\Models\Menu;

    $menuByModul = Menu::with(['menuParent','menuChild'])
    ->where('route','LIKE',request()->segment(1)."%")
    ->whereNull('app_menu_id_parent')
    ->orderBy('order',"asc")
    ->get()
    ->toArray();

$currentSegment = implode("/",request()->segments());
@endphp
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @foreach($menuByModul as $key => $menu)
                    {{-- Jika menu bukan parent / hanya berdiri sendiri --}}
                    @if(empty($menu['menu_child']))
                        <li
                            class="sidebar-item {{ $menu['route'] ===  $currentSegment ? "active" : "" }}">
                            <a href="{{ url($menu['route']) }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>{{ $menu['name'] }}</span>
                            </a>
                        </li>
                    {{-- Jika menu parent dan mempunyai anakan menu --}}
                    @elseif(!empty($menu['menu_child']))
                        <li
                            class="sidebar-item {{ in_array($currentSegment,array_column($menu['menu_child'],'route')) ? "active" : "" }} has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>{{ $menu['name'] }}</span>
                            </a>
                            <ul class="submenu {{ in_array($currentSegment,array_column($menu['menu_child'],'route')) ? "active" : "" }}">
                                @foreach($menu['menu_child'] as $key => $child)
                                    <li class="submenu-item {{ $child['route'] === $currentSegment ? "active" : "" }}">
                                        <a href="{{ url($child['route']) }}">{{ $child['name'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
