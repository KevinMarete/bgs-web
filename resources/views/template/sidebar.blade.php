<nav class="sb-sidenav sb-shadow-right sb-sidenav-light">
    <div class="sb-sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sb-sidenav-menu-heading">Admin</div>
            <a class="nav-link" href="/dashboard">
                <div class="sb-nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Buyer</div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i data-feather="layout"></i></div>
                Search
            </a>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseComponents" aria-expanded="false" aria-controls="collapseComponents">
                <div class="sb-nav-link-icon"><i data-feather="package"></i></div>
                Products
            </a>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
                <div class="sb-nav-link-icon"><i data-feather="tool"></i></div>
                Deals & Promotions
            </a>
            <div class="sb-sidenav-menu-heading">Seller</div>
            <a class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i data-feather="bar-chart"></i></div>
                Products
            </a>
            <a class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i data-feather="filter"></i></div>
                Deals
            </a>
            <a class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i data-feather="filter"></i></div>
                Promotions
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div>
            <div class="small">Logged in as:</div>
            {{ session()->get('firstname').' '.session()->get('lastname') }}
        </div>
    </div>
</nav>