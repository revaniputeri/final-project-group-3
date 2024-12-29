<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <!-- Logo di bagian kiri -->
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="/">
      <img src="/assets/img/logo-prestacc.png" alt="logo" style="width: 120px; height: auto;" />
    </a>
  </div>
  <!-- Link di bagian kanan -->
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <div class="menu-right">
        <a href="/login" class="nav-link" style="margin-right: 0;">
            <span class="nav-user-name mr-1">
                <?= isset($_SESSION['user']['fullName']) ? htmlspecialchars($_SESSION['user']['fullName']) : 'Login' ?>
            </span>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 2): ?>
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
    </div>
  </div>
</nav>