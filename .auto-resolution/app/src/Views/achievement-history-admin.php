<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-admin.php'; ?>

    <!-- Main Panel -->
    <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
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

        <!-- Footer -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
            </div>
        </footer>
    </div>
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