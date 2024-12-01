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
                                <div class="d-flex">
                                    <select class="form-control mr-2" id="tahun" name="tahun">
                                        <?php 
                                        $currentYear = date('Y');
                                        for($year = $currentYear; $year >= $currentYear - 4; $year--) {
                                            $selected = ($year == ($selectedYear ?? $currentYear)) ? 'selected' : '';
                                            echo "<option value='$year' $selected>$year</option>";
                                        }
                                        ?>
                                    </select>
                                    <select class="form-control" id="semester" name="semester">
                                        <option value="1" <?= ($selectedSemester ?? '') == '1' ? 'selected' : '' ?>>Semester Ganjil</option>
                                        <option value="2" <?= ($selectedSemester ?? '') == '2' ? 'selected' : '' ?>>Semester Genap</option>
                                    </select>
                                </div>
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
                                            foreach ($topAchievements as $achievement) : 
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($achievement['Fullname']) ?></td>
                                                <td><?= htmlspecialchars($achievement['StudentMajor']) ?></td>
                                                <td><?= number_format($achievement['TotalPoints'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php 
                                            endforeach;
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
    document.getElementById('semester').addEventListener('change', updateTopAchievements);

    function updateTopAchievements() {
        const tahun = document.getElementById('tahun').value;
        const semester = document.getElementById('semester').value;
        
        // Redirect atau Ajax call
        window.location.href = `/dashboard?tahun=${tahun}&semester=${semester}`;
    }
</script>