<nav class="sb-topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
    <a class="navbar-brand d-none d-sm-block text-center" href="/dashboard">
        <!-- Logo Image -->
        <img src="/assets/img/logo.jpg" alt="" height="60" class="rounded d-inline-block align-middle mr-2">
    </a>
    <button class="btn sb-btn-icon sb-btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#">
        <i data-feather="code"></i>
    </button>
    <p class="mb-0 text-center">
        <em class="text-warning">
            Pharmahub....Increasing your profitability
        </em>
        <i data-feather="phone"></i>
        <em class="text-warning">
            <a href="tel:{{ str_replace(['(', ')'], ['', ''], env('CONTACT_PHONE')) }}">{{ env('CONTACT_PHONE') }} </a>
        </em>
    </p>
    <form class="form-inline mr-auto d-none d-lg-block">
    </form>
    <ul class="navbar-nav align-items-center">
        <li class="nav-item dropdown no-caret mr-3 sb-dropdown-user">
            <a class="btn sb-btn-icon sb-btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="sb-dropdown-user-img" data-feather="user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <i class="sb-dropdown-user-img" data-feather="user"></i>
                    <div class="sb-dropdown-user-details">
                        <div class="sb-dropdown-user-details-name">{{ session()->get('firstname').' '.session()->get('lastname') }}</div>
                        <div class="sb-dropdown-user-details-email">{{ session()->get('email') }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/account">
                    <div class="sb-dropdown-item-icon"><i data-feather="settings"></i></div>
                    Account
                </a><a class="dropdown-item" href="/sign-out">
                    <div class="sb-dropdown-item-icon"><i data-feather="log-out"></i></div>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>