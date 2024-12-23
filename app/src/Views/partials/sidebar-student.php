<nav class="sidebar sidebar-offcanvas pt-5" id="sidebar" style="position: fixed; height: 100%;">
  <ul class="nav">
    <?php
    if ($_SESSION['user']['role'] == 2): ?>
      <li class="nav-item">
        <a class="nav-link" href="/dashboard/home">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6.75c0-1.768 0-2.652.55-3.2C4.097 3 4.981 3 6.75 3s2.652 0 3.2.55c.55.548.55 1.432.55 3.2s0 2.652-.55 3.2c-.548.55-1.432.55-3.2.55s-2.652 0-3.2-.55C3 9.403 3 8.519 3 6.75m0 10.507c0-1.768 0-2.652.55-3.2c.548-.55 1.432-.55 3.2-.55s2.652 0 3.2.55c.55.548.55 1.432.55 3.2s0 2.652-.55 3.2c-.548.55-1.432.55-3.2.55s-2.652 0-3.2-.55C3 19.91 3 19.026 3 17.258M13.5 6.75c0-1.768 0-2.652.55-3.2c.548-.55 1.432-.55 3.2-.55s2.652 0 3.2.55c.55.548.55 1.432.55 3.2s0 2.652-.55 3.2c-.548.55-1.432.55-3.2.55s-2.652 0-3.2-.55c-.55-.548-.55-1.432-.55-3.2m0 10.507c0-1.768 0-2.652.55-3.2c.548-.55 1.432-.55 3.2-.55s2.652 0 3.2.55c.55.548.55 1.432.55 3.2s0 2.652-.55 3.2c-.548.55-1.432.55-3.2.55s-2.652 0-3.2-.55c-.55-.548-.55-1.432-.55-3.2" />
          </svg>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dashboard/achievement/form">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
              <path d="M14.217 3.5a5.17 5.17 0 0 0-4.434 0L3.092 6.637c-1.456.682-1.456 3.044 0 3.726l6.69 3.137a5.17 5.17 0 0 0 4.435 0l6.691-3.137c1.456-.682 1.456-3.044 0-3.726zM22 8.5v5" />
              <path d="M5 11.5v5.125C5 19.543 9.694 21 12 21s7-1.457 7-4.375V11.5" />
            </g>
          </svg>
          <span class="menu-title">Prestasi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dashboard/achievement/history">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
              <path d="M3.25 13h3.68a2 2 0 0 1 1.664.89l.812 1.22a2 2 0 0 0 1.664.89h1.86a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 17.07 13h3.68" />
              <path d="m5.45 4.11l-2.162 7.847A8 8 0 0 0 3 14.082V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4.918a8 8 0 0 0-.288-2.125L18.55 4.11A2 2 0 0 0 16.76 3H7.24a2 2 0 0 0-1.79 1.11M9 9.5h6m-4.5-3h3" />
            </g>
          </svg>
          <span class="menu-title">Riwayat Prestasi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dashboard/info">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
              <path d="M21 12a9 9 0 1 1-18 0a9 9 0 0 1 18 0" />
              <path d="M12 16v-5h-.5m0 5h1M12 8.5V8" />
            </g>
          </svg>
          <span class="menu-title">Informasi Prestasi</span>
        </a>
      </li>
    <?php elseif ($_SESSION['user']['role'] == 1): ?>
      <li class="nav-item">
        <a class="nav-link" href="/admin/dashboard">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6.75c0-1.768 0-2.652.55-3.2C4.097 3 4.981 3 6.75 3s2.652 0 3.2.55c.55.548.55 1.432.55 3.2s0 2.652-.55 3.2c-.548.55-1.432.55-3.2.55s-2.652 0-3.2-.55C3 9.403 3 8.519 3 6.75m0 10.507c0-1.768 0-2.652.55-3.2c.548-.55 1.432-.55 3.2-.55s2.652 0 3.2.55c.55.548.55 1.432.55 3.2s0 2.652-.55 3.2c-.548.55-1.432.55-3.2.55s-2.652 0-3.2-.55C3 19.91 3 19.026 3 17.258M13.5 6.75c0-1.768 0-2.652.55-3.2c.548-.55 1.432-.55 3.2-.55s2.652 0 3.2.55c.55.548.55 1.432.55 3.2s0 2.652-.55 3.2c-.548.55-1.432.55-3.2.55s-2.652 0-3.2-.55c-.55-.548-.55-1.432-.55-3.2m0 10.507c0-1.768 0-2.652.55-3.2c.548-.55 1.432-.55 3.2-.55s2.652 0 3.2.55c.55.548.55 1.432.55 3.2s0 2.652-.55 3.2c-.548.55-1.432.55-3.2.55s-2.652 0-3.2-.55c-.55-.548-.55-1.432-.55-3.2" />
          </svg>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/achievement/history">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
              <path d="M3.25 13h3.68a2 2 0 0 1 1.664.89l.812 1.22a2 2 0 0 0 1.664.89h1.86a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 17.07 13h3.68" />
              <path d="m5.45 4.11l-2.162 7.847A8 8 0 0 0 3 14.082V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4.918a8 8 0 0 0-.288-2.125L18.55 4.11A2 2 0 0 0 16.76 3H7.24a2 2 0 0 0-1.79 1.11M9 9.5h6m-4.5-3h3" />
            </g>
          </svg>
          <span class="menu-title">Daftar Prestasi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/info">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
              <path d="M21 12a9 9 0 1 1-18 0a9 9 0 0 1 18 0" />
              <path d="M12 16v-5h-.5m0 5h1M12 8.5V8" />
            </g>
          </svg>
          <span class="menu-title">Informasi Prestasi</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>