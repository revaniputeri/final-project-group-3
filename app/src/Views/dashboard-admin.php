<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
</head>

<body>
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <div class="container-fluid page-body-wrapper">
        <?php include __DIR__ . '/partials/sidebar-admin.php'; ?>
        <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
            <div class="content-wrapper">
                <div class="row pt-5">
                    <div class="col-md-12 grid-margin">
                        <div class="row">
                            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <h1 class="font-weight-bold">Selamat Datang, Admin</h1>
                                <p class="text-muted">Pantau dan kelola prestasi mahasiswa melalui dashboard yang mudah digunakan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Accepted Students Box -->
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <h4 class="card-title text-success">Jumlah Mahasiswa Diterima</h4>
                                <h2 class="font-weight-bold"><?= $acceptedCount ?></h2>
                                <a href="/admin/achievement/accepted" class="btn btn-success btn-lg btn-block">
                                    Lihat Prestasi Mahasiswa Diterima
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Rejected Students Box -->
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card border-danger">
                            <div class="card-body text-center">
                                <h4 class="card-title text-danger">Jumlah Mahasiswa Ditolak</h4>
                                <h2 class="font-weight-bold"><?= $rejectedCount ?></h2>
                                <a href="/admin/achievement/rejected" class="btn btn-danger btn-lg btn-block">
                                    Lihat Prestasi Mahasiswa Ditolak
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Info Menu Box -->
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <h4 class="card-title text-info">Buku Panduan Prestasi</h4>
                                <p class="card-description" style="margin-bottom: 20px;">
                                    Pelajari kebijakan dan informasi seputar prestasi mahasiswa
                                </p>
                                <a href="/dashboard/info" class="btn btn-info btn-lg btn-block">
                                    <i class="ti-book mr-2"></i>
                                    Baca Buku Panduan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Top 10 Achievement Section -->
                <div class="row mt-4">
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

                <!-- SVG Image Section -->
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <img src="app/skydash template/images/dashboard/people.svg" alt="Dashboard Illustration" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
            <?php require __DIR__ . '/partials/footer-page.php'; ?>
        </div>
    </div>
</body>

</html>