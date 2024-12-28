<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
        <div class="content-wrapper">
            <div class="row pt-5">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Detail Prestasi</h4>
                            <p class="card-description mb-4">
                                Detail prestasi Anda. Semua field bersifat read-only.
                            </p>

                            <div>
                                <input type="hidden" name="achievementId" value="<?= $achievement['Id'] ?>">
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <!-- Informasi Dasar Kompetisi -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Informasi Dasar</h5>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionTitle">Judul Kompetisi
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionTitle"
                                                        name="competitionTitle"
                                                        value="<?= $achievement['CompetitionTitle'] ?>"
                                                        placeholder="Judul Kompetisi dalam Bahasa Indonesia" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionTitleEnglish">Judul
                                                        Kompetisi (Bahasa Inggris) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionTitleEnglish"
                                                        name="competitionTitleEnglish"
                                                        value="<?= $achievement['CompetitionTitleEnglish'] ?>"
                                                        placeholder="Judul Kompetisi dalam Bahasa Inggris" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionType">Jenis Kompetisi
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionType"
                                                        name="competitionType"
                                                        value="<?= $achievement['CompetitionType'] ?>" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionLevel">Tingkat Kompetisi
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionLevel"
                                                        name="competitionLevel"
                                                        value="<?= $achievement['CompetitionLevelName'] ?>" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionRank">Peringkat Kompetisi
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionRank"
                                                        name="competitionRank"
                                                        value="<?= $achievement['CompetitionRankName'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Detail Kompetisi -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Detail Kompetisi</h5>

                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="competitionPlace">Tempat/Penyelenggara Kompetisi <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionPlace"
                                                        name="competitionPlace"
                                                        value="<?= $achievement['CompetitionPlace'] ?>"
                                                        placeholder="Tempat Kompetisi dalam Bahasa Indonesia" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="competitionPlaceEnglish">Tempat/Penyelenggara Kompetisi
                                                        (Bahasa Inggris) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionPlaceEnglish"
                                                        name="competitionPlaceEnglish"
                                                        value="<?= $achievement['CompetitionPlaceEnglish'] ?>"
                                                        placeholder="Tempat Kompetisi dalam Bahasa Inggris" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionUrl">URL Kompetisi <span
                                                            class="text-danger">*</span></label>
                                                    <input type="url" class="form-control" id="competitionUrl"
                                                        name="competitionUrl"
                                                        value="<?= $achievement['CompetitionUrl'] ?>"
                                                        placeholder="Alamat Website Kompetisi" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Periode Kompetisi <span
                                                            class="text-danger">*</span></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="competitionStartDate">Tanggal Mulai</label>
                                                                <input type="date" class="form-control"
                                                                    id="competitionStartDate"
                                                                    name="competitionStartDate"
                                                                    value="<?= date('Y-m-d', strtotime($achievement['CompetitionStartDate'])) ?>"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="competitionEndDate">Tanggal Selesai</label>
                                                                <input type="date" class="form-control"
                                                                    id="competitionEndDate" name="competitionEndDate"
                                                                    value="<?= date('Y-m-d', strtotime($achievement['CompetitionEndDate'])) ?>"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <!-- Informasi Partisipasi -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Informasi Partisipasi</h5>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="numberOfInstitutions">Jumlah
                                                        Institusi Peserta <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="numberOfInstitutions"
                                                        name="numberOfInstitutions"
                                                        value="<?= $achievement['NumberOfInstitutions'] ?>"
                                                        placeholder="Total jumlah institusi" min="0" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="numberOfStudents">Jumlah Siswa
                                                        Peserta <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="numberOfStudents"
                                                        name="numberOfStudents"
                                                        value="<?= $achievement['NumberOfStudents'] ?>"
                                                        placeholder="Total jumlah siswa" min="1" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="letterNumber">Nomor Surat <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="letterNumber"
                                                        name="letterNumber" value="<?= $achievement['LetterNumber'] ?>"
                                                        placeholder="Nomor Surat Resmi" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="letterDate">Tanggal Surat <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="letterDate"
                                                        name="letterDate"
                                                        value="<?= date('Y-m-d', strtotime($achievement['LetterDate'])) ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dokumen Pendukung -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Dokumen Pendukung</h5>
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="letterFile">File Surat</label>
                                                    <div class="d-flex">
                                                        <div class="custom-file flex-grow-1">
                                                            <input type="text" class="form-control" id="letterFile"
                                                                name="letterFile"
                                                                value="<?= $achievement['LetterFile'] ?>" readonly>
                                                        </div>
                                                        <?php if ($achievement['LetterFile']): ?>
                                                            <a href="/storage/achievements/<?= $achievement['LetterFile'] ?>"
                                                                target="_blank" class="btn btn-info btn-sm ml-2"><i
                                                                    class="fas fa-eye"></i> Lihat File</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="certificateFile">File
                                                        Sertifikat</label>
                                                    <div class="d-flex">
                                                        <div class="custom-file flex-grow-1">
                                                            <input type="text" class="form-control" id="certificateFile"
                                                                name="certificateFile"
                                                                value="<?= $achievement['CertificateFile'] ?>" readonly>
                                                        </div>
                                                        <?php if ($achievement['CertificateFile']): ?>
                                                            <a href="/storage/achievements/<?= $achievement['CertificateFile'] ?>"
                                                                target="_blank" class="btn btn-info btn-sm ml-2"><i
                                                                    class="fas fa-eye"></i> Lihat File</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="documentationFile">File
                                                        Dokumentasi</label>
                                                    <div class="d-flex">
                                                        <div class="custom-file flex-grow-1">
                                                            <input type="text" class="form-control"
                                                                id="documentationFile" name="documentationFile"
                                                                value="<?= $achievement['DocumentationFile'] ?>"
                                                                readonly>
                                                        </div>
                                                        <?php if ($achievement['DocumentationFile']): ?>
                                                            <a href="/storage/achievements/<?= $achievement['DocumentationFile'] ?>"
                                                                target="_blank" class="btn btn-info btn-sm ml-2"><i
                                                                    class="fas fa-eye"></i> Lihat File</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="posterFile">File Poster</label>
                                                    <div class="d-flex">
                                                        <div class="custom-file flex-grow-1">
                                                            <input type="text" class="form-control" id="posterFile"
                                                                name="posterFile"
                                                                value="<?= $achievement['PosterFile'] ?>" readonly>
                                                        </div>
                                                        <?php if ($achievement['PosterFile']): ?>
                                                            <a href="/storage/achievements/<?= $achievement['PosterFile'] ?>"
                                                                target="_blank" class="btn btn-info btn-sm ml-2"><i
                                                                    class="fas fa-eye"></i> Lihat File</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dosen Pembimbing dan Anggota Tim -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Dosen Pembimbing & Anggota Tim
                                                </h5>

                                                <!-- Dosen Pembimbing -->
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Dosen Pembimbing</label>
                                                    <div id="supervisorContainer">
                                                        <?php if (isset($supervisors) && is_array($supervisors)): ?>
                                                            <?php foreach ($supervisors as $supervisor): ?>
                                                                <div class="input-group mb-2">
                                                                    <input type="text" class="form-control"
                                                                        value="<?= $supervisor['FullName'] ?>" readonly>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control"
                                                                    value="No supervisors available" readonly>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <!-- Anggota Tim -->
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Anggota Tim</label>
                                                    <div id="teamMemberContainer">
                                                        <?php
                                                        if (empty($teamLeaders) && empty($teamMembers) && empty($teamMembersPersonal)):
                                                        ?>
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control"
                                                                    value="Tidak ada anggota tim" readonly>
                                                            </div>
                                                            <?php
                                                        else:
                                                            $allMembers = array_merge(
                                                                is_array($teamLeaders) ? $teamLeaders : [],
                                                                is_array($teamMembers) ? $teamMembers : [],
                                                                is_array($teamMembersPersonal) ? $teamMembersPersonal : []
                                                            );
                                                            foreach ($allMembers as $index => $member):
                                                            ?>
                                                                <div class="input-group mb-2">
                                                                    <input type="text" class="form-control"
                                                                        value="<?= htmlspecialchars($member['FullName']) ?>"
                                                                        readonly>
                                                                    <input type="text"
                                                                        class="form-control anggota-tim-peran ml-0   "
                                                                        value="<?= $member['AchievementRole'] == '2' ? 'Ketua' : ($member['AchievementRole'] == '3' ? 'Anggota' : ($member['AchievementRole'] == '4' ? 'Personal' : '')) ?>"
                                                                        readonly>
                                                                </div>
                                                        <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($achievement['AdminValidationStatus'] === 'REJECTED' || $achievement['AdminValidationStatus'] === 'APPROVED'): ?>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Komentar Admin</h5>
                                                <div class="form-group">
                                                    <textarea class="form-control" id="adminComment" name="adminComment" rows="4" placeholder="Tulis komentar di sini..." readonly><?= htmlspecialchars($achievement['AdminComment']) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row mt-4"></div>
                            <form method="POST" action="/admin/achievement/update-validation">
                                <input type="hidden" name="achievementId" value="<?= $achievement['Id'] ?>">
                                <?php if ($_SESSION['user']['role'] === 1 && $achievement['AdminValidationStatus'] === 'PENDING'): ?>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="card shadow-sm mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title text-primary mb-4">Komentar Admin</h5>
                                                    <div class="form-group">
                                                        <textarea class="form-control" id="adminComment" name="adminComment" rows="4" placeholder="Tulis komentar di sini..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <?php if ($_SESSION['user']['role'] === 1): ?>
                                            <button type="submit" name="APPROVED" value="APPROVED" class="btn btn-success btn-md px-3" <?= $achievement['AdminValidationStatus'] !== 'PENDING' ? 'disabled' : '' ?>>
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                            <button type="submit" name="REJECTED" value="REJECTED" class="btn btn-danger btn-md px-3" <?= $achievement['AdminValidationStatus'] !== 'PENDING' ? 'disabled' : '' ?>>
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                            <button onclick="window.history.back()" class="btn btn-secondary btn-md px-3">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </but>
                                        <?php else: ?>
                                            <button onclick="window.history.back()" class="btn btn-primary btn-md px-3">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>
<script>

</script>