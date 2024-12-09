<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
</head>

<body>
    <?php include _DIR_ . '/partials/navbar.php'; ?>

    <div class="container-fluid page-body-wrapper">
        <?php include _DIR_ . '/partials/sidebar-admin.php'; ?>
        <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
            <div class="content-wrapper">
                <div class="row pt-5">
                    <div class="col-md-12 grid-margin">
                        <div class="row">
                            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <h1 class="font-weight-bold">Selamat Datang di PrestaC</h1>
                                <p class="text-muted">Pantau dan kelola prestasi mahasiswa melalui dashboard yang mudah digunakan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Weather Info Box -->
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card tale-bg">
                            <div class="card-people mt-auto pt-0">
                                <img src="/assets/img/people_dashboard.jpg" alt="people">
                                <div class="weather-info" style="left: 24px;">
                                    <div class="d-flex">
                                        <div class="ml-2">
                                            <h4 class="location font-weight-normal"><?= date('l') ?></h4>
                                            <h6 class="font-weight-normal"><?= date('d F Y') ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin transparent">
                        <div class="row">
                            <div class="col-md-6 mb-4 stretch-card transparent">
                                <div class="card card-tale" style="background-color: #6EC207;">
                                    <div class="card-body">
                                        <p class="mb-4">Total Prestasi Diterima</p>
                                        <p class="fs-30 mb-2"><?= $_SESSION['user']['fullName'] == 'Admin Pusat' ? $acceptedCountPusat : $acceptedCount ?></p>
                                        <?php if ($_SESSION['user']['fullName'] != 'Admin Pusat') : ?>
                                            <p>Prodi: <?= str_replace("Admin Program Studi ", "", $_SESSION['user']['fullName']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 stretch-card transparent">
                                <div class="card card-dark-blue" style="background-color: #B8001F; color: white;">
                                    <div class="card-body">
                                        <p class="mb-4">Total Prestasi Ditolak</p>
                                        <p class="fs-30 mb-2"><?= $_SESSION['user']['fullName'] == 'Admin Pusat' ? $rejectedCountPusat : $rejectedCount ?></p>
                                        <?php if ($_SESSION['user']['fullName'] != 'Admin Pusat') : ?>
                                            <p>Prodi: <?= str_replace("Admin Program Studi ", "", $_SESSION['user']['fullName']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                                <div class="card card-light-blue" style="background-color: #4B49AC;">
                                    <div class="card-body">
                                        <p class="mb-4">Total Prestasi</p>
                                        <p class="fs-30 mb-2"><?= $_SESSION['user']['fullName'] == 'Admin Pusat' ? $totalOfAchievementsPusat : $totalOfAchievementsByProdi ?></p>
                                        <?php if ($_SESSION['user']['fullName'] != 'Admin Pusat') : ?>
                                            <p>Prodi: <?= str_replace("Admin Program Studi ", "", $_SESSION['user']['fullName']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 stretch-card transparent">
                                <div class="card card-light-danger" style="background-color: #FFB200;">
                                    <div class="card-body">
                                        <p class="mb-4">Total Prestasi Pending</p>
                                        <p class="fs-30 mb-2"><?= $_SESSION['user']['fullName'] == 'Admin Pusat' ? $pendingCountPusat : $pendingCount ?></p>
                                        <?php if ($_SESSION['user']['fullName'] != 'Admin Pusat') : ?>
                                            <p>Prodi: <?= str_replace("Admin Program Studi ", "", $_SESSION['user']['fullName']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Top 10 Achievement Section -->
                    <div class="row mt-4 ml-1" style="width: 801px;">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="card-title">Top 10 Prestasi Tertinggi</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Program Studi</th>
                                                    <th>Total Poin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($topAchievements)) {
                                                    $no = 1;
                                                    foreach ($topAchievements as $achievement) {
                                                ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td><?= htmlspecialchars($achievement['CompetitionTitle']) ?></td>
                                                            <td><?= htmlspecialchars($achievement['CompetitionLevel']) ?></td>
                                                            <td><?= number_format($achievement['CompetitionPoints'], 0, ',', '.') ?></td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="4" class="text-center">Tidak ada prestasi yang ditemukan.</td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php require _DIR_ . '/partials/footer-page.php'; ?>
            </div>
        </div>
</body>

</html>