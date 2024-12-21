<nav class="sidebar sidebar-offcanvas pt-5" id="sidebar" style="position: fixed; height: 100%;">
  <ul class="nav">
    <?php
    if ($_SESSION['user']['role'] == 2): ?>
      <li class="nav-item">
        <a class="nav-link" href="/dashboard/home">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dashboard/achievement/form">
          <i class="icon-paper menu-icon"></i>
          <span class="menu-title">Prestasi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dashboard/achievement/history">
          <i class="icon-paper menu-icon"></i>
          <span class="menu-title">Riwayat Prestasi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dashboard/info">
          <i class="icon-paper menu-icon"></i>
          <span class="menu-title">Informasi Prestasi</span>
        </a>
      </li>
    <?php elseif ($_SESSION['user']['role'] == 1): ?>
      <li class="nav-item">
        <a class="nav-link" href="/admin/dashboard">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/achievement/history">
          <i class="icon-paper menu-icon"></i>
          <span class="menu-title">Daftar Prestasi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/info">
          <i class="icon-paper menu-icon"></i>
          <span class="menu-title">Informasi Prestasi</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>