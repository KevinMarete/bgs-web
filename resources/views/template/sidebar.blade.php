<nav class="sb-sidenav sb-shadow-right sb-sidenav-light">
    <div class="sb-sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sb-sidenav-menu-heading">{{ session()->get('organization.organization_type.name').'<>'.session()->get('organization.name') }}</div>
            @foreach ($menus as $menu_item)
                <a class="nav-link {{ str_replace('/', ' ', strtolower($menu_item['menu']['link'])) }}" href="{{ $menu_item['menu']['link'] }}">
                    <div class="sb-nav-link-icon"><i data-feather="{{ $menu_item['menu']['icon'] }}"></i></div>
                    {{ $menu_item['menu']['name'] }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div>
            <div class="small">Logged in as: {{ strtoupper(session()->get('organization.organization_type.role.name')) }} </div>
            {{ session()->get('firstname').' '.session()->get('lastname') }}
        </div>
    </div>
</nav>