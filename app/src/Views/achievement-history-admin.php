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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">Riwayat Prestasi Mahasiswa</h4>
                            </div>

                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%; vertical-align: middle;">No</th>
                                            <th class="text-center" style="width: 10%;">Tanggal<br>Dibuat</th>
                                            <th class="text-center" style="width: 10%;">Tanggal<br>Diubah</th>
                                            <th class="text-center" style="width: 15%;">Nama<br>Mahasiswa</th>
                                            <th class="text-center" style="width: 20%;">Judul<br>Kompetisi</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">Tingkat</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">Peringkat</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">Status</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($achievements)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Belum ada prestasi yang tercatat</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($achievements as $index => $achievement): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= date('d/m/y', strtotime($achievement['CreatedAt'])) ?></td>
                                                    <td><?= date('d/m/y', strtotime($achievement['UpdatedAt']))?></td>
                                                    <td>
                                                        <div><strong><?= $achievement['FullName'] ?></strong></div>
                                                        <div style="margin-top: 5px;"><?= $achievement['username'] ?></div>
                                                    </td>
                                                    <td class="truncate-text"><?= $achievement['CompetitionTitle'] ?></td>
                                                    <td><?= $achievement['CompetitionLevelName'] ?></td>
                                                    <td><?= $achievement['CompetitionRankName'] ?></td>
                                                    <td>
                                                        <?php
                                                        $statusClasses = [
                                                            'PENDING' => 'badge-warning',
                                                            'APPROVED' => 'badge-success',
                                                            'REJECTED' => 'badge-danger'
                                                        ];
                                                        $badgeClass = $statusClasses[$achievement['AdminValidationStatus']] ?? 'badge-secondary';
                                                        ?>
                                                        <label class="badge <?= $badgeClass ?>">
                                                            <?= $achievement['AdminValidationStatus'] ?>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <div class="dropdown">
                                                                <div class="dropdown-toggle" type="button" id="actionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </div>
                                                                <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                                    <a class="dropdown-item" href="/dashboard/achievement/view/<?= $achievement['Id'] ?>">Lihat</a>
                                                                    <a class="dropdown-item" href="/dashboard/achievement/edit/<?= $achievement['Id'] ?>">Edit</a>
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