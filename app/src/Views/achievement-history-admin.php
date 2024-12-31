<?php include __DIR__ . '/partials/navbar.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <!-- Main Panel -->
    <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Riwayat Prestasi Mahasiswa</h4>
                                <div class="d-flex align-items-center">
                                    <a href="/download/laporan?<?= http_build_query($_GET) ?>" class="btn btn-primary mr-2" download>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5" d="M9 3.5v17m11.5-11h-17M3 9.4c0-2.24 0-3.36.436-4.216a4 4 0 0 1 1.748-1.748C6.04 3 7.16 3 9.4 3h5.2c2.24 0 3.36 0 4.216.436a4 4 0 0 1 1.748 1.748C21 6.04 21 7.16 21 9.4v5.2c0 2.24 0 3.36-.436 4.216a4 4 0 0 1-1.748 1.748C17.96 21 16.84 21 14.6 21H9.4c-2.24 0-3.36 0-4.216-.436a4 4 0 0 1-1.748-1.748C3 17.96 3 16.84 3 14.6z" />
                                        </svg>
                                        Export Excel
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="dropdown mr-2">
                                    <button class="btn btn-white btn-sm dropdown-toggle shadow-sm" type="button" id="statusFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= isset($_GET['status']) ? "Status: " . htmlspecialchars($_GET['status']) : 'Filter Status' ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="statusFilterDropdown">
                                        <a class="dropdown-item" href="<?= $_SESSION['user']['role'] == 1 ? '/admin' : '/dashboard' ?>/achievement/history?<?= http_build_query(array_merge($_GET, ['status' => null])) ?>">Semua</a>
                                        <?php foreach ($statusAchievement as $status): ?>
                                            <a class="dropdown-item" href="<?= $_SESSION['user']['role'] == 1 ? '/admin' : '/dashboard' ?>/achievement/history?<?= http_build_query(array_merge($_GET, ['status' => $status])) ?>"><?= $status ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="form-group mr-2 mb-0">
                                        <input type="date" class="form-control form-control-sm" id="startDate" name="startDate" value="<?= $_GET['start'] ?? '' ?>">
                                    </div>
                                    <div class="mr-2">s/d</div>
                                    <div class="form-group mr-2 mb-0">
                                        <input type="date" class="form-control form-control-sm" id="endDate" name="endDate" value="<?= $_GET['end'] ?? '' ?>">
                                    </div>
                                    <button type="button" class="btn btn-white btn-sm shadow-sm" onclick="applyDateFilter()">
                                        Terapkan
                                    </button>
                                </div>
                                <div class="ml-auto mr-2">
                                    <form action="<?= $_SESSION['user']['role'] == 1 ? '/admin' : '/dashboard' ?>/achievement/history" method="get" class="d-flex">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                id="searchInput"
                                                name="search"
                                                placeholder="Cari..."
                                                style="width: 250px; height: 38px;"
                                                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="ti-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <script>
                                    function applyDateFilter() {
                                        const startDate = document.getElementById('startDate').value;
                                        const endDate = document.getElementById('endDate').value;
                                        const baseUrl = '<?= $_SESSION['user']['role'] == 1 ? '/admin' : '/dashboard' ?>/achievement/history';
                                        const queryParams = new URLSearchParams(window.location.search);

                                        if (startDate) {
                                            queryParams.set('start', startDate);
                                        } else {
                                            queryParams.delete('start');
                                        }

                                        if (endDate) {
                                            queryParams.set('end', endDate);
                                        } else {
                                            queryParams.delete('end');
                                        }

                                        window.location.href = baseUrl + '?' + queryParams.toString();
                                    }
                                </script>
                            </div>
                            <div class="table-responsive rounded mt-3" style="overflow-x: auto; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #dee2e6;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr style="outline: 2px solid #dee2e6;">
                                            <th class="text-center" style="width: 5%; vertical-align: middle;">No</th>
                                            <th class="text-center" style="width: 10%;">Tanggal<br>Dibuat</th>
                                            <th class="text-center" style="width: 10%;">Tanggal<br>Diubah</th>
                                            <th class="text-center" style="width: 15%;">Nama<br>Mahasiswa</th>
                                            <th class="text-center" style="width: 20%; vertical-align: middle;">Judul Kompetisi</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">Tingkat</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">Peringkat</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">Status</th>
                                            <th class="text-center" style="width: 5%; vertical-align: middle;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($achievements)): ?>
                                            <tr>
                                                <td colspan="9" class="text-center">Belum ada prestasi yang tercatat</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($achievements as $index => $achievement): ?>
                                                <tr style="text-align: center;">
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= date('d/m/y', strtotime($achievement['CreatedAt'])) ?></td>
                                                    <td><?= date('d/m/y', strtotime($achievement['UpdatedAt'])) ?></td>
                                                    <td>
                                                        <div><strong><?= $achievement['Fullname'] ?></strong></div>
                                                        <div style="margin-top: 5px;"><?= $achievement['username'] ?></div>
                                                    </td>
                                                    <td class="truncate-text"><?= $achievement['CompetitionTitle'] ?></td>
                                                    <td><?= $achievement['CompetitionLevelName'] ?></td>
                                                    <td><?= $achievement['CompetitionRankName'] ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        $statusClasses = [
                                                            'PROSES' => 'badge-warning',
                                                            'DITERIMA' => 'badge-success',
                                                            'DITOLAK' => 'badge-danger'
                                                        ];
                                                        $badgeClass = $statusClasses[$achievement['AdminValidationStatus']] ?? 'badge-secondary';
                                                        ?>
                                                        <label class="badge <?= $badgeClass ?>">
                                                            <?= $achievement['AdminValidationStatus'] ?>
                                                        </label>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <div class="dropdown">
                                                                <div class="dropdown-toggle" type="button" id="actionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </div>
                                                                <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                                    <a class="dropdown-item" href="/dashboard/achievement/view/<?= $achievement['Id'] ?>">Lihat</a>
                                                                    <a class="dropdown-item" onclick="confirmDelete(<?= $achievement['Id'] ?>)">Hapus</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Penghapusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>
<script>
    let achievementIdToDelete = null;

    function confirmDelete(id) {
        achievementIdToDelete = id;
        $('#deleteModal').modal('show');
    }

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (achievementIdToDelete) {
            // Create and submit a form programmatically
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/dashboard/achievement/delete/${achievementIdToDelete}`;
            document.body.appendChild(form);
            form.submit();
        }
    });
</script>
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .truncate-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 180px;
    }
</style>