<<<<<<< ours
<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>
    <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
        <div class="content-wrapper">
            <div class="row pt-5">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h1 class="font-weight-bold">Selamat Datang di PrestaC</h1>
                            <p class="text-muted">Pantau dan kelola prestasi Anda melalui dashboard yang mudah digunakan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Submission Form Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tambah Prestasi</h4>
                            <p class="card-description">
                                Klik disini untuk menambah prestasi baru
                            </p>
                            <a href="/dashboard/achievement/form" class="btn btn-primary btn-lg btn-block">
                                <i class="ti-plus mr-2"></i>
                                Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kotak Menu Riwayat Prestasi -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Riwayat Prestasi</h4>
                            <p class="card-description">
                                Lihat riwayat prestasi Anda
                            </p>
                            <a href="/dashboard/achievement/history" class="btn btn-info btn-lg btn-block">
                                <i class="ti-list mr-2"></i>
                                Lihat Riwayat
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Buku Panduan Prestasi</h4>
                            <p class="card-description">
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
                            <?php var_dump($topAchievements); ?>
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
                                            ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada data prestasi</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>

<script>
    document.getElementById('tahun').addEventListener('change', updateTopAchievements);
    
    function updateTopAchievements() {
        const tahun = document.getElementById('tahun').value;
        
        // Redirect or Ajax call
        window.location.href = `/dashboard?tahun=${tahun}`;
    }
||||||| ancestor
<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row pt-5">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h1 class="font-weight-bold">Selamat Datang di Dashboard PrestaC</h1>
                            <p class="text-muted">Pantau dan kelola prestasi Anda melalui dashboard yang mudah digunakan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Submission Form Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tambah Prestasi</h4>
                            <p class="card-description">
                                Klik disini untuk menambah prestasi baru
                            </p>
                            <a href="/dashboard/achievement/form" class="btn btn-primary btn-lg btn-block">
                                <i class="ti-plus mr-2"></i>
                                Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Achievement History Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Achievement History</h4>
                            <p class="card-description">
                                View your achievement history
                            </p>
                            <a href="/dashboard/achievement/history" class="btn btn-info btn-lg btn-block">
                                <i class="ti-list mr-2"></i>
                                View History
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Informasi Prestasi</h4>
                            <p class="card-description">
                                Periksa statistik prestasi Anda
                            </p>
                            <a href="/dashboard/achievement/info" class="btn btn-success btn-lg btn-block">
                                <i class="ti-bar-chart mr-2"></i>
                                Lihat Statistik
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
                            <?php var_dump($topAchievements); ?>
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
                                            ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada data prestasi</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>

<script>
    document.getElementById('tahun').addEventListener('change', updateTopAchievements);

    function updateTopAchievements() {
        const tahun = document.getElementById('tahun').value;

        // Redirect or Ajax call
        window.location.href = `/dashboard?tahun=${tahun}`;
    }
=======
<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>
    <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
        <div class="content-wrapper">
            <div class="row pt-5">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h1 class="font-weight-bold">Selamat Datang di PrestaC</h1>
                            <p class="text-muted">Pantau dan kelola prestasi Anda melalui dashboard yang mudah digunakan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Submission Form Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tambah Prestasi</h4>
                            <p class="card-description">
                                Klik disini untuk menambah prestasi baru
                            </p>
                            <a href="/dashboard/achievement/form" class="btn btn-primary btn-lg btn-block">
                                <i class="ti-plus mr-2"></i>
                                Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kotak Menu Riwayat Prestasi -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Riwayat Prestasi</h4>
                            <p class="card-description">
                                Lihat riwayat prestasi Anda
                            </p>
                            <a href="/dashboard/achievement/history" class="btn btn-info btn-lg btn-block">
                                <i class="ti-list mr-2"></i>
                                Lihat Riwayat
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Buku Panduan Prestasi</h4>
                            <p class="card-description">
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
                            <?php var_dump($topAchievements); ?>
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
                                            ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada data prestasi</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>

<script>
    document.getElementById('tahun').addEventListener('change', updateTopAchievements);
    
    function updateTopAchievements() {
        const tahun = document.getElementById('tahun').value;
        
        // Redirect or Ajax call
        window.location.href = `/dashboard?tahun=${tahun}`;
    }
>>>>>>> theirs
</script>