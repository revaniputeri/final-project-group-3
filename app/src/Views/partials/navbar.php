<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="/"><img src="/assets/img/prestac.png" class="mr-2" alt="logo" style="width: 140px; height: auto; margin-top: 20px; " /></a>
    <a class="navbar-brand brand-logo-mini" href="/"><img src="/assets/img/logo-prestac-mini.png" alt="logo" style="width: 50px; height: auto;" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" id="toggle-sidebar-button" data-toggle="minimize">
      <span class="icon-menu" id="toggle-sidebar-icon"></span>
    </button>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <span class="nav-user-name mr-2 mt-3"><?= isset($_SESSION['user']['fullName']) ? htmlspecialchars($_SESSION['user']['fullName']) : '' ?></span>
          <i class="icon-head menu-icon mb-1" id="profile-icon"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="/dashboard/profile-customization">
            <i class="ti-settings text-primary"></i>
            Profile
          </a>
          <form action="/logout" method="post" style="display: inline;">
            <button type="submit" class="dropdown-item">
              <i class="ti-power-off text-primary"></i>
              Logout
            </button>
          </form>
        </div>
      </li>
    </ul>
  </div>
</nav>