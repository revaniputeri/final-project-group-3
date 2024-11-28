<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="row pt-5">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Edit Prestasi</h4>
                            <p class="card-description mb-4">
                                Edit data prestasi yang telah disubmit. Tanda <span class="text-danger">*</span> menandakan wajib diisi.
                            </p>

                            <form class="forms-sample" method="POST" action="/dashboard/achievement/edit/<?= $achievement['Id'] ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <!-- Informasi Dasar Kompetisi -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Informasi Dasar</h5>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionTitle">Judul Kompetisi <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionTitle" name="competitionTitle" value="<?= htmlspecialchars($achievement['CompetitionTitle']) ?>" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionTitleEnglish">Judul Kompetisi (Bahasa Inggris) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionTitleEnglish" name="competitionTitleEnglish" value="<?= htmlspecialchars($achievement['CompetitionTitleEnglish']) ?>" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionType">Jenis Kompetisi <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="competitionType" name="competitionType" required>
                                                        <option value="">Pilih Jenis Kompetisi</option>
                                                        <option value="Sains" <?= $achievement['CompetitionType'] == 'Sains' ? 'selected' : '' ?>>Sains</option>
                                                        <option value="Seni" <?= $achievement['CompetitionType'] == 'Seni' ? 'selected' : '' ?>>Seni</option>
                                                        <option value="Olahraga" <?= $achievement['CompetitionType'] == 'Olahraga' ? 'selected' : '' ?>>Olahraga</option>
                                                        <option value="Lain-Lain" <?= $achievement['CompetitionType'] == 'Lain-Lain' ? 'selected' : '' ?>>Lain-Lain</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionLevel">Tingkat Kompetisi <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="competitionLevel" name="competitionLevel" required>
                                                        <option value="">Pilih Tingkat Kompetisi</option>
                                                        <?php foreach ($competitionLevels as $id => $level): ?>
                                                            <option value="<?= $id ?>" <?= $achievement['CompetitionLevel'] == $id ? 'selected' : '' ?>>
                                                                <?= $level['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionRank">Peringkat Kompetisi <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="competitionRank" name="competitionRank" required>
                                                        <option value="">Pilih Peringkat Kompetisi</option>
                                                        <?php foreach ($competitionRanks as $id => $rank): ?>
                                                            <option value="<?= $id ?>" <?= $achievement['CompetitionRank'] == $id ? 'selected' : '' ?>>
                                                                <?= $rank['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Detail Kompetisi -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Detail Kompetisi</h5>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionPlace">Tempat/Penyelenggara Kompetisi <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionPlace" name="competitionPlace" value="<?= htmlspecialchars($achievement['CompetitionPlace']) ?>" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionPlaceEnglish">Tempat/Penyelenggara Kompetisi (Bahasa Inggris) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionPlaceEnglish" name="competitionPlaceEnglish" value="<?= htmlspecialchars($achievement['CompetitionPlaceEnglish']) ?>" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionUrl">URL Kompetisi <span class="text-danger">*</span></label>
                                                    <input type="url" class="form-control" id="competitionUrl" name="competitionUrl" value="<?= htmlspecialchars($achievement['CompetitionUrl']) ?>" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Periode Kompetisi <span class="text-danger">*</span></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="competitionStartDate">Tanggal Mulai</label>
                                                                <input type="date" class="form-control" id="competitionStartDate" name="competitionStartDate" value="<?= date('Y-m-d', strtotime($achievement['CompetitionStartDate'])) ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="competitionEndDate">Tanggal Selesai</label>
                                                                <input type="date" class="form-control" id="competitionEndDate" name="competitionEndDate" value="<?= date('Y-m-d', strtotime($achievement['CompetitionEndDate'])) ?>" required>
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
                                                    <label class="form-label" for="numberOfInstitutions">Jumlah Institusi Peserta <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="numberOfInstitutions" name="numberOfInstitutions" value="<?= htmlspecialchars($achievement['NumberOfInstitutions']) ?>" min="0" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="numberOfStudents">Jumlah Siswa Peserta <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="numberOfStudents" name="numberOfStudents" value="<?= htmlspecialchars($achievement['NumberOfStudents']) ?>" min="1" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="letterNumber">Nomor Surat <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="letterNumber" name="letterNumber" value="<?= htmlspecialchars($achievement['LetterNumber']) ?>" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="letterDate">Tanggal Surat <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="letterDate" name="letterDate" value="<?= date('Y-m-d', strtotime($achievement['LetterDate'])) ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dokumen Pendukung -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Dokumen Pendukung</h5>
                                                <div class="alert alert-info">
                                                    <small>Format file yang diizinkan: PDF, JPEG, PNG (Maks 5MB)</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="letterFile">File Surat Tugas</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="letterFile" name="letterFile" accept=".pdf,.jpg,.jpeg,.png">
                                                        <?php if ($achievement['LetterFile']): ?>
                                                            <div class="input-group-append">
                                                                <a href="/storage/achievements/letters/<?= basename($achievement['LetterFile']) ?>" class="btn btn-info" target="_blank">
                                                                    <i class="ti-eye"></i> Lihat File
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="certificateFile">File Sertifikat</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="certificateFile" name="certificateFile" accept=".pdf,.jpg,.jpeg,.png">
                                                        <?php if ($achievement['CertificateFile']): ?>
                                                            <div class="input-group-append">
                                                                <a href="/storage/achievements/certificates/<?= basename($achievement['CertificateFile']) ?>" class="btn btn-info" target="_blank">
                                                                    <i class="ti-eye"></i> Lihat File
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="documentationFile">File Dokumentasi</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="documentationFile" name="documentationFile" accept=".pdf,.jpg,.jpeg,.png">
                                                        <?php if ($achievement['DocumentationFile']): ?>
                                                            <div class="input-group-append">
                                                                <a href="/storage/achievements/documentation/<?= basename($achievement['DocumentationFile']) ?>" class="btn btn-info" target="_blank">
                                                                    <i class="ti-eye"></i> Lihat File
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="posterFile">File Poster</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="posterFile" name="posterFile" accept=".pdf,.jpg,.jpeg,.png">
                                                        <?php if ($achievement['PosterFile']): ?>
                                                            <div class="input-group-append">
                                                                <a href="/storage/achievements/posters/<?= basename($achievement['PosterFile']) ?>" class="btn btn-info" target="_blank">
                                                                    <i class="ti-eye"></i> Lihat File
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dosen Pembimbing dan Anggota Tim -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Dosen Pembimbing & Anggota Tim</h5>

                                                <!-- Dosen Pembimbing -->
                                                <div class="form-group">
                                                    <label>Dosen Pembimbing <span class="text-danger">*</span></label>
                                                    <div id="supervisorContainer">
                                                        <?php foreach ($supervisors as $supervisor): ?>
                                                            <div class="input-group mb-2">
                                                                <select class="form-control select2-dropdown" name="supervisors[]" required>
                                                                    <option value="">Pilih Dosen Pembimbing</option>
                                                                    <?php foreach ($lecturers as $lecturer): ?>
                                                                        <option value="<?= $lecturer['Id'] ?>" <?= $supervisor['Id'] == $lecturer['Id'] ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($lecturer['FullName']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-danger remove-supervisor">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <button type="button" class="btn btn-success btn-sm mt-2" onclick="achievementForm.addSupervisor()">
                                                        <i class="ti-plus"></i> Tambah Dosen Pembimbing
                                                    </button>
                                                </div>

                                                <!-- Anggota Tim -->
                                                <div class="form-group">
                                                    <label>Anggota Tim</label>
                                                    <div id="teamMemberContainer">
                                                        <?php foreach ($teamMembers as $member): ?>
                                                            <div class="input-group mb-2">
                                                                <select class="form-control select2-dropdown" name="teamMembers[]">
                                                                    <option value="">Pilih Anggota Tim</option>
                                                                    <?php foreach ($students as $student): ?>
                                                                        <option value="<?= $student['Id'] ?>" <?= $member['Id'] == $student['Id'] ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($student['FullName']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <select class="form-control" name="teamMemberRoles[]" style="width: 150px;">
                                                                    <option value="Ketua" <?= $member['AchievementRole'] == 2 ? 'selected' : '' ?>>Ketua</option>
                                                                    <option value="Anggota" <?= $member['AchievementRole'] == 3 ? 'selected' : '' ?>>Anggota</option>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-danger remove-team-member">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <button type="button" class="btn btn-success btn-sm mt-2" onclick="achievementForm.addTeamMember()">
                                                        <i class="ti-plus"></i> Tambah Anggota Tim
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn btn-primary btn-lg px-4 mr-3">
                                            <i class="fas fa-paper-plane mr-2"></i> Simpan
                                        </button>
                                        <a href="/dashboard/achievement/history" class="btn btn-light btn-lg px-4">
                                            <i class="fas fa-undo mr-2"></i> Batal
                                        </a>
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
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = this.files[0]?.name || 'Pilih file';
            const label = this.nextElementSibling;
            label.textContent = fileName;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const rankSelect = document.getElementById('competitionRank');
        const levelSelect = document.getElementById('competitionLevel');

        const ranks = <?= json_encode($competitionRanks) ?>;
        const levels = <?= json_encode($competitionLevels) ?>;

        function calculatePoints() {
            const rankPoints = ranks[rankSelect.value]?.points ?? 0;
            const levelMultiplier = levels[levelSelect.value]?.multiplier ?? 1;
            const totalPoints = rankPoints * levelMultiplier;
        }

        rankSelect.addEventListener('change', calculatePoints);
        levelSelect.addEventListener('change', calculatePoints);
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="/assets/css/achievement-submission.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/assets/js/achievement-submission.js"></script>
<script src="/vendors/js/vendor.bundle.base.js"></script>
<script src="/js/off-canvas.js"></script>
<script src="/js/hoverable-collapse.js"></script>
<script src="/js/template.js"></script>
<script src="/assets/js/achievement-edit.js"></script>