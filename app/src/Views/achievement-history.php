    <?php include __DIR__ . '/partials/navbar.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <div class="container-fluid page-body-wrapper">
        <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

        <!-- Main Panel -->
        <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
            <div class="content-wrapper">
                <div class="row pt-5">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title">Riwayat Prestasi Saya</h4>
                                    <a href="/dashboard/achievement/form" class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah Prestasi
                                    </a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Judul Kompetisi</th>
                                                <th>Tempat</th>
                                                <th>Peringkat</th>
                                                <th>Tingkat</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($achievements)): ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Belum ada data prestasi yang tersedia</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($achievements as $achievement): ?>
                                                    <tr>
                                                        <td><?= date('d M Y', strtotime($achievement['CreatedAt'])) ?></td>
                                                        <td><?= htmlspecialchars($achievement['CompetitionTitle']) ?></td>
                                                        <td><?= htmlspecialchars($achievement['CompetitionPlace']) ?></td>
                                                        <td><?= htmlspecialchars($achievement['CompetitionRankName']) ?></td>
                                                        <td><?= htmlspecialchars($achievement['CompetitionLevelName']) ?></td>
                                                        <td>
                                                            <?php
                                                            $statusClasses = [
                                                                'PENDING' => 'badge-warning',
                                                                'APPROVED' => 'badge-success',
                                                                'REJECTED' => 'badge-danger'
                                                            ];

                                                            $adminBadgeClass = $statusClasses[$achievement['AdminValidationStatus']] ?? 'badge-secondary';
                                                            ?>
                                                            <div class="mt-1">
                                                                <label class="badge <?= $adminBadgeClass ?>">
                                                                    Admin: <?= $achievement['AdminValidationStatus'] ?>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="/dashboard/achievement/view/<?= $achievement['Id'] ?>" class="btn btn-info btn-sm" title="View">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <?php if ($achievement['AdminValidationStatus'] === 'PENDING'): ?>
                                                                    <a href="/dashboard/achievement/edit/<?= $achievement['Id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                                                                        <i class="ti-pencil"></i>
                                                                    </a>
                                                                    <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDelete(<?= $achievement['Id'] ?>)">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                <?php endif; ?>
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
            <?php require __DIR__ . '/partials/footer-page.php'; ?>
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
    </style>