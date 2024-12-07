<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row pt-5">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Edit Prestasi</h4>
                            <p class="card-description mb-4">
                                Edit detail prestasi Anda. Tanda <span class="text-danger">*</span> menandakan wajib diisi.
                            </p>

                            <form class="forms-sample" method="POST" action="/dashboard/achievement/edit/<?= $achievement['Id'] ?>" enctype="multipart/form-data">
                                <input type="hidden" name="achievementId" value="<?= $achievement['Id'] ?>">
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <!-- Informasi Dasar Kompetisi -->
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary mb-4">Informasi Dasar</h5>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionTitle">Judul Kompetisi <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionTitle" name="competitionTitle" value="<?= $achievement['CompetitionTitle'] ?>" placeholder="Judul Kompetisi dalam Bahasa Indonesia" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionTitleEnglish">Judul Kompetisi (Bahasa Inggris) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionTitleEnglish" name="competitionTitleEnglish" value="<?= $achievement['CompetitionTitleEnglish'] ?>" placeholder="Judul Kompetisi dalam Bahasa Inggris" required>
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
                                                            <option value="<?= $id ?>" <?= $achievement['CompetitionLevel'] == $id ? 'selected' : '' ?>><?= $level['name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionRank">Peringkat Kompetisi <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="competitionRank" name="competitionRank" required>
                                                        <option value="">Pilih Peringkat Kompetisi</option>
                                                        <?php foreach ($competitionRanks as $id => $rank): ?>
                                                            <option value="<?= $id ?>" <?= $achievement['CompetitionRank'] == $id ? 'selected' : '' ?>><?= $rank['name'] ?></option>
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
                                                    <input type="text" class="form-control" id="competitionPlace" name="competitionPlace" value="<?= $achievement['CompetitionPlace'] ?>" placeholder="Tempat Kompetisi dalam Bahasa Indonesia" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionPlaceEnglish">Tempat/Penyelenggara Kompetisi (Bahasa Inggris) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="competitionPlaceEnglish" name="competitionPlaceEnglish" value="<?= $achievement['CompetitionPlaceEnglish'] ?>" placeholder="Tempat Kompetisi dalam Bahasa Inggris" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="competitionUrl">URL Kompetisi <span class="text-danger">*</span></label>
                                                    <input type="url" class="form-control" id="competitionUrl" name="competitionUrl" value="<?= $achievement['CompetitionUrl'] ?>" placeholder="Alamat Website Kompetisi" required>
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
                                                    <input type="number" class="form-control" id="numberOfInstitutions" name="numberOfInstitutions" value="<?= $achievement['NumberOfInstitutions'] ?>" placeholder="Total jumlah institusi" min="0" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="numberOfStudents">Jumlah Siswa Peserta <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="numberOfStudentsEdit" name="numberOfStudents" value="<?= $achievement['NumberOfStudents'] ?>" placeholder="Total jumlah siswa" min="1" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="letterNumber">Nomor Surat <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="letterNumber" name="letterNumber" value="<?= $achievement['LetterNumber'] ?>" placeholder="Nomor Surat Resmi" required>
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
                                                    <small>Format file yang diizinkan: PDF, JPEG, PNG (Maks 5MB). Biarkan kosong jika tidak ingin mengubah file.</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="letterFile">File Surat</label>
                                                    <div class="d-flex">
                                                        <div class="custom-file flex-grow-1">
                                                            <input type="file" class="custom-file-input" id="letterFile" name="letterFile" accept=".pdf,.jpeg,.jpg,.png">
                                                            <label class="custom-file-label" for="letterFile">Pilih file</label>
                                                        </div>
                                                        <?php if ($achievement['LetterFile']): ?>
                                                            <a href="/storage/achievements/<?= $achievement['LetterFile'] ?>" target="_blank" class="btn btn-info btn-sm ml-2"><i class="fas fa-eye"></i> Lihat File</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="certificateFile">File Sertifikat</label>
                                                    <div class="d-flex">
                                                        <div class="custom-file flex-grow-1">
                                                            <input type="file" class="custom-file-input" id="certificateFile" name="certificateFile" accept=".pdf,.jpeg,.jpg,.png">
                                                            <label class="custom-file-label" for="certificateFile">Pilih file</label>
                                                        </div>
                                                        <?php if ($achievement['CertificateFile']): ?>
                                                            <a href="/storage/achievements/<?= $achievement['CertificateFile'] ?>" target="_blank" class="btn btn-info btn-sm ml-2"><i class="fas fa-eye"></i> Lihat File</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="documentationFile">File Dokumentasi</label>
                                                    <div class="d-flex">
                                                        <div class="custom-file flex-grow-1">
                                                            <input type="file" class="custom-file-input" id="documentationFile" name="documentationFile" accept=".pdf,.jpeg,.jpg,.png">
                                                            <label class="custom-file-label" for="documentationFile">Pilih file</label>
                                                        </div>
                                                        <?php if ($achievement['DocumentationFile']): ?>
                                                            <a href="/storage/achievements/<?= $achievement['DocumentationFile'] ?>" target="_blank" class="btn btn-info btn-sm ml-2"><i class="fas fa-eye"></i> Lihat File</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="posterFile">File Poster</label>
                                                    <div class="d-flex">
                                                        <div class="custom-file flex-grow-1">
                                                            <input type="file" class="custom-file-input" id="posterFile" name="posterFile" accept=".pdf,.jpeg,.jpg,.png">
                                                            <label class="custom-file-label" for="posterFile">Pilih file</label>
                                                        </div>
                                                        <?php if ($achievement['PosterFile']): ?>
                                                            <a href="/storage/achievements/<?= $achievement['PosterFile'] ?>" target="_blank" class="btn btn-info btn-sm ml-2"><i class="fas fa-eye"></i> Lihat File</a>
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
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Dosen Pembimbing</label>
                                                    <div id="supervisorContainer">
                                                        <?php
                                                        if (empty($supervisors)):
                                                        ?>
                                                            <div class="input-group mb-2">
                                                                <select class="form-control dosen-pembimbing" name="supervisors[]">
                                                                    <option value="">Pilih Dosen Pembimbing</option>
                                                                    <?php foreach ($lecturers as $lecturer): ?>
                                                                        <option value="<?= $lecturer['Id'] ?>"><?= $lecturer['FullName'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-success" onclick="achievementForm.addSupervisor()">
                                                                        <i class="fas fa-plus">+</i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        else:
                                                            foreach ($supervisors as $index => $supervisor):
                                                            ?>
                                                                <div class="input-group mb-2">
                                                                    <select class="form-control dosen-pembimbing" name="supervisors[]">
                                                                        <option value="">Pilih Dosen Pembimbing</option>
                                                                        <?php foreach ($lecturers as $lecturer): ?>
                                                                            <option value="<?= $lecturer['Id'] ?>" <?= $supervisor['Id'] == $lecturer['Id'] ? 'selected' : '' ?>><?= $lecturer['FullName'] ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <div class="input-group-append">
                                                                        <?php if ($index > 0): ?>
                                                                            <button type="button" class="btn btn-danger" onclick="achievementForm.removeSupervisor(this)">
                                                                                <i class="fas fa-minus">-</i>
                                                                            </button>
                                                                        <?php endif; ?>
                                                                        <button type="button" class="btn btn-success" onclick="achievementForm.addSupervisor()">
                                                                            <i class="fas fa-plus">+</i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                        <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </div>
                                                </div>

                                                <!-- Anggota Tim -->
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Anggota Tim</label>
                                                    <div id="teamMemberContainer">
                                                        <?php
                                                        // Jika tidak ada anggota tim, tampilkan satu baris form kosong
                                                        if (empty($teamLeaders) && empty($teamMembers)):
                                                        ?>
                                                            <div class="input-group mb-2">
                                                                <select class="form-control anggota-tim" name="teamMembers[]" required>
                                                                    <option value="">Pilih Anggota Tim</option>
                                                                    <?php foreach ($students as $student): ?>
                                                                        <option value="<?= $student['Id'] ?>"><?= $student['FullName'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <select class="form-control anggota-tim-peran" name="teamMemberRoles[]" required>
                                                                    <option value="">Pilih Peran</option>
                                                                    <option value="Ketua">Ketua</option>
                                                                    <option value="Anggota">Anggota</option>
                                                                    <option value="Personal">Personal</option>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-success" onclick="achievementForm.addTeamMember()">
                                                                        <i class="fas fa-plus">+</i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        // Jika ada anggota tim, tampilkan data yang ada
                                                        else:
                                                            $allMembers = array_merge(
                                                                is_array($teamLeaders) ? $teamLeaders : [],
                                                                is_array($teamMembers) ? $teamMembers : []
                                                            );
                                                            foreach ($allMembers as $index => $member):
                                                            ?>
                                                                <div class="input-group mb-2">
                                                                    <select class="form-control anggota-tim" name="teamMembers[]" required>
                                                                        <option value="">Pilih Anggota Tim</option>
                                                                        <?php foreach ($students as $student): ?>
                                                                            <?php
                                                                            $isSelected = is_array($member) && isset($member['Id']) && $member['Id'] == $student['Id'];
                                                                            ?>
                                                                            <option value="<?= $student['Id'] ?>" <?= $isSelected ? 'selected' : '' ?>><?= $student['FullName'] ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <select class="form-control anggota-tim-peran" name="teamMemberRoles[]" required>
                                                                        <option value="">Pilih Peran</option>
                                                                        <option value="Ketua" <?= $member['AchievementRole'] == '2' ? 'selected' : '' ?>>Ketua</option>
                                                                        <option value="Anggota" <?= $member['AchievementRole'] == '3' ? 'selected' : '' ?>>Anggota</option>
                                                                        <option value="Personal" <?= $member['AchievementRole'] == '4' ? 'selected' : '' ?>>Personal</option>
                                                                    </select>
                                                                    <div class="input-group-append">
                                                                        <?php if ($index > 0): ?>
                                                                            <button type="button" class="btn btn-danger" onclick="achievementForm.removeTeamMember(this)">
                                                                                <i class="fas fa-minus">-</i>
                                                                            </button>
                                                                        <?php endif; ?>
                                                                        <button type="button" class="btn btn-success" onclick="achievementForm.addTeamMember()">
                                                                            <i class="fas fa-plus">+</i>
                                                                        </button>
                                                                    </div>
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

                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <button type="submit" id="submitButton" class="btn btn-primary btn-lg px-4 mr-3">
                                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                        </button>
                                        <a href="/dashboard/achievement/history" class="btn btn-light btn-lg px-4">
                                            <i class="fas fa-times mr-2"></i> Batal
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
    // Pass PHP data to JavaScript
    window.LECTURER_OPTIONS = `<?php foreach ($lecturers as $lecturer): ?>
        <option value="<?= $lecturer['Id'] ?>"><?= $lecturer['FullName'] ?></option>
    <?php endforeach; ?>`;

    window.STUDENT_OPTIONS = `<?php foreach ($students as $student): ?>
        <option value="<?= $student['Id'] ?>"><?= $student['FullName'] ?></option>
    <?php endforeach; ?>`;

    window.COMPETITION_RANKS = <?= json_encode($competitionRanks) ?>;
    window.COMPETITION_LEVELS = <?= json_encode($competitionLevels) ?>;
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="/assets/css/achievement-submission.css" rel="stylesheet" />
<script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/assets/js/achievement-submission.js"></script>
<script src="/vendors/js/vendor.bundle.base.js"></script>
<script src="/js/off-canvas.js"></script>
<script src="/js/hoverable-collapse.js"></script>
<script src="/js/template.js"></script>