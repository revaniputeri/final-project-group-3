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
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Riwayat Prestasi Saya</h4>
                                    <div class="d-flex align-items-center">
                                        <a href="/dashboard/achievement/form" class="btn btn-primary mr-2">
                                            <i class="ti-plus"></i> Tambah Prestasi
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown mr-2">
                                        <button class="btn btn-white btn-sm dropdown-toggle shadow-sm" type="button" id="statusFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Filter Status
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="statusFilterDropdown">
                                            <a class="dropdown-item" href="#">Semua</a>
                                            <a class="dropdown-item" href="#">Pending</a>
                                            <a class="dropdown-item" href="#">Approved</a>
                                            <a class="dropdown-item" href="#">Rejected</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-white btn-sm dropdown-toggle shadow-sm" type="button" id="periodFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Filter Periode
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="periodFilterDropdown">
                                            <a class="dropdown-item" href="/achievement/history?period=all">Semua</a>
                                            <?php foreach ($periods as $period): ?>
                                                <a class="dropdown-item" href="/achievement/history?period=<?= urlencode($period['label']) ?>"><?= $period['label'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Tanggal<br>Dibuat</th>
                                                <th>Tanggal<br>Diubah</th>
                                                <th style="vertical-align: middle;">Judul Kompetisi</th>
                                                <th style="vertical-align: middle;">Tempat</th>
                                                <th style="vertical-align: middle;">Peringkat</th>
                                                <th style="vertical-align: middle;">Tingkat</th>
                                                <th style="vertical-align: middle;">Status</th>
                                                <th style="vertical-align: middle;">Aksi</th>
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
                                                        <td><?= date('d/m/y', strtotime($achievement['CreatedAt'])) ?></td>
                                                        <td><?= date('d/m/y', strtotime($achievement['UpdatedAt'])) ?></td>
                                                        <td class="truncate-text"><?= htmlspecialchars($achievement['CompetitionTitle']) ?></td>
                                                        <td class="truncate-text"><?= htmlspecialchars($achievement['CompetitionPlace']) ?></td>
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
                                                                    <?= $achievement['AdminValidationStatus'] ?>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="/dashboard/achievement/view/<?= $achievement['Id'] ?>" class="btn btn-info btn-sm" title="View">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <?= ($achievement['AdminValidationStatus'] === 'APPROVED')
                                                                    ? '<a href="#" class="btn btn-warning btn-sm disabled" title="Edit" aria-disabled="true"><i class="ti-pencil"></i></a>'
                                                                    : '<a href="/dashboard/achievement/edit/' . $achievement['Id'] . '" class="btn btn-warning btn-sm" title="Edit"><i class="ti-pencil"></i></a>'; ?>
                                                                <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDelete(<?= $achievement['Id'] ?>)">
                                                                    <i class="ti-trash"></i>
                                                                </button>
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

        .truncate-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }
    </style>
    <script defer src="/assets/js/achievement-history.js"></script>