@php
    use App\Models\Menu;
    use App\Models\User;

    $userGroupId = User::with(['userGroup'])->whereId(auth()->id())->first()->userGroup->id;
    $menuByModul = Menu::with(['menuParent','menuChild','accessMenu'])
    ->where('route','LIKE',request()->segment(1)."%")
    ->whereNull('app_menu_id_parent');

    if(auth()->user()->username != "superadmin"){
        $menuByModul = $menuByModul->whereRelation("accessMenu","app_group_user_id","=",$userGroupId);
    }

    $menuByModul = $menuByModul->orderBy('order',"asc")
    ->get()
    ->toArray()
@endphp
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @foreach($menuByModul as $key => $menu)
                    @php
                        $segments = request()->segments();
                        $arrRoute = explode("/",$menu['route']);
                        $currentSegment = implode(request()->segments());

                        /// We have to get the same value from both arrays
                        /// When total same value > 2, we assume this menu should be active
                        $intersectSegment = array_intersect($segments,$arrRoute);
                        $isSameSegment = count($intersectSegment) >= 2
                    @endphp
                    {{-- Jika menu bukan parent / hanya berdiri sendiri --}}
                    @if(empty($menu['menu_child']))
                        <li
                            class="sidebar-item {{ $isSameSegment  ? "active" : "" }}">
                            <a href="{{ url($menu['route']) }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>{{ $menu['name'] }}</span>
                            </a>
                        </li>
                        {{-- Jika menu parent dan mempunyai anakan menu --}}
                    @elseif(!empty($menu['menu_child']))
                        <li
                            class="sidebar-item {{ $isSameSegment ? "active" : "" }} has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>{{ $menu['name'] }}</span>
                            </a>
                            <ul class="submenu {{ $isSameSegment ? "active" : "" }}">
                                @foreach($menu['menu_child'] as $key => $child)
                                    @php
                                        /// We override `$isSameSegment` & `$arrRoute` to special case when menu have children
                                        /// Before, `$isSameSegment` can true if >= 2
                                        /// Then when have children, `$isSameSegment` can true if >= 3
                                        $arrRoute  = explode("/",$child['route']);
                                        $intersectSegment = array_intersect($segments,$arrRoute);
                                        $isSameSegment = count($intersectSegment) >= 3
                                    @endphp
                                    <li class="submenu-item {{ $isSameSegment ? "active" : "" }}">
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
