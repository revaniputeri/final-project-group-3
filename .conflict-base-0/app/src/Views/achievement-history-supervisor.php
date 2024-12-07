<div class="container-scroller">
    <!-- Navbar -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo mr-5" href="/"><img src="/assets/img/logo-prestac.png" class="mr-2" alt="logo" style="width: 150px; height: auto;" /></a>
            <a class="navbar-brand brand-logo-mini" href="/"><img src="/assets/img/logo-prestac-mini.png" alt="logo" style="width: 50px; height: auto;" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center position-absolute" type="button" data-toggle="minimize" style="left: 220px;">
                <span class="icon-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <i class="icon-head menu-icon"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="/dashboard/profile/customize">
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

    <div class="container-fluid page-body-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar sidebar-offcanvas pt-5" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/supervisor/validation">
                        <i class="icon-paper menu-icon"></i>
                        <span class="menu-title">Riwayat Prestasi</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Panel -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title">Riwayat Prestasi Mahasiswa</h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Mahasiswa</th>
                                                <th>Judul Kompetisi</th>
                                                <th>Tingkat</th>
                                                <th>Peringkat</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($achievements as $achievement): ?>
                                                <tr>
                                                    <td><?= date('d M Y', strtotime($achievement['SubmissionDate'])) ?></td>
                                                    <td><?= $achievement['StudentName'] ?></td>
                                                    <td><?= $achievement['CompetitionTitle'] ?></td>
                                                    <td><?= $achievement['CompetitionLevel'] ?></td>
                                                    <td><?= $achievement['CompetitionRank'] ?></td>
                                                    <td>
                                                        <?php
                                                        $statusClasses = [
                                                            'Pending' => 'badge-warning',
                                                            'Approved' => 'badge-success',
                                                            'Rejected' => 'badge-danger'
                                                        ];
                                                        $badgeClass = $statusClasses[$achievement['Status']] ?? 'badge-secondary';
                                                        ?>
                                                        <label class="badge <?= $badgeClass ?>"><?= $achievement['Status'] ?></label>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="/dashboard/achievement/view/<?= $achievement['Id'] ?>" class="btn btn-info btn-sm" title="View">
                                                                <i class="ti-eye"></i>
                                                            </a>
                                                            <?php if ($achievement['Status'] === 'Pending'): ?>
                                                                <button type="button" class="btn btn-success btn-sm" title="Approve"
                                                                    onclick="confirmApprove(<?= $achievement['Id'] ?>)">
                                                                    <i class="ti-check"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm" title="Reject"
                                                                    onclick="confirmReject(<?= $achievement['Id'] ?>)">
                                                                    <i class="ti-close"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>