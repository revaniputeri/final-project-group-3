<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <!-- Brand Logo Section -->
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="/">
            <img src="/assets/img/prestac.png" class="mr-2" alt="logo" style="width: 140px; height: auto;">
        </a>
        <a class="navbar-brand brand-logo-mini" href="/">
            <img src="/assets/img/logo-prestac-mini.png" alt="logo" style="width: 50px; height: auto;">
        </a>
    </div>

    <!-- Menu Section -->
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <!-- Sidebar Toggle Button -->
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" id="toggle-sidebar-button" data-toggle="minimize">
            <span class="icon-menu" id="toggle-sidebar-icon"></span>
        </button>

        <!-- User Profile Dropdown -->
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <span class="nav-user-name mr-1">
                        <?= isset($_SESSION['user']['fullName']) ? htmlspecialchars($_SESSION['user']['fullName']) : '' ?>
                    </span>
                    <?php if ($_SESSION['user']['role'] == 2): ?>
                        <?php 
                        if (!isset($_SESSION['user']['profile_picture'])) {
                            $_SESSION['user']['profile_picture'] = 'https://api.dicebear.com/9.x/big-smile/svg?seed=' . 
                                (isset($_SESSION['user']['fullName']) ? urlencode(htmlspecialchars($_SESSION['user']['fullName'])) : 'default') . 
                                '&backgroundType=gradientLinear&backgroundColor=b6e3f4,c0aede,d1d4f9';
                        }
                        ?>
                        <img src="<?= htmlspecialchars($_SESSION['user']['profile_picture']) ?>" class="rounded-circle" alt="Profile Picture" style="width: 30px; height: 30px; object-fit: cover;">
                    <?php else: ?>
                        <i class="icon-head menu-icon rounded-circle mb-1" style="font-size: 18px; padding: 5px;"></i>
                    <?php endif; ?>
                </a>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <?php if ($_SESSION['user']['role'] !== 1): ?>
                        <a class="dropdown-item" href="/dashboard/profile">
                            <i class="ti-settings text-primary"></i>
                            Profile
                        </a>
                    <?php endif; ?>

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