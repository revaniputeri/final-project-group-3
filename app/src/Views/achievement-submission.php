<?php include __DIR__ . '/partials/navbar.php'; ?>

<?php
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
if (isset($_SESSION['form_data'])) {
  unset($_SESSION['form_data']);
}
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<div class="container-fluid page-body-wrapper">
  <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

  <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
    <div class="content-wrapper">
      <div class="row pt-5">
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show ml-3" role="alert">
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
              <h4 class="card-title mb-4">Formulir Pengajuan Prestasi</h4>
              <p class="card-description mb-4">
                Masukkan detail prestasi Anda. Tanda <span class="text-danger">*</span> menandakan wajib diisi.
              </p>

              <form class="forms-sample" method="POST" action="/dashboard/achievement/form"
                enctype="multipart/form-data">
                <div class="row">
                  <!-- Kolom Kiri -->
                  <div class="col-md-6">
                    <!-- Informasi Dasar Kompetisi -->
                    <div class="card shadow-sm mb-4">
                      <div class="card-body">
                        <h5 class="card-title text-primary mb-4">Informasi Dasar</h5>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionTitle">Judul Kompetisi <span
                              class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="competitionTitle" name="competitionTitle"
                            value="<?= isset($formData['competitionTitle']) ? htmlspecialchars($formData['competitionTitle']) : '' ?>"
                            placeholder="Judul Kompetisi dalam Bahasa Indonesia" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionTitleEnglish">Judul Kompetisi (Bahasa Inggris)
                            <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="competitionTitleEnglish"
                            name="competitionTitleEnglish"
                            value="<?= isset($formData['competitionTitleEnglish']) ? htmlspecialchars($formData['competitionTitleEnglish']) : '' ?>"
                            placeholder="Judul Kompetisi dalam Bahasa Inggris" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionType">Jenis Kompetisi <span
                              class="text-danger">*</span></label>
                          <select class="form-control" id="competitionType" name="competitionType" required>
                            <option value="">Pilih Jenis Kompetisi</option>
                            <option value="Sains" <?= (isset($formData['competitionType']) && $formData['competitionType'] == 'Sains') ? 'selected' : '' ?>>Sains</option>
                            <option value="Seni" <?= (isset($formData['competitionType']) && $formData['competitionType'] == 'Seni') ? 'selected' : '' ?>>Seni</option>
                            <option value="Olahraga" <?= (isset($formData['competitionType']) && $formData['competitionType'] == 'Olahraga') ? 'selected' : '' ?>>Olahraga</option>
                            <option value="Lain-Lain" <?= (isset($formData['competitionType']) && $formData['competitionType'] == 'Lain-Lain') ? 'selected' : '' ?>>Lain-Lain</option>
                          </select>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionLevel">Tingkat Kompetisi <span
                              class="text-danger">*</span></label>
                          <select class="form-control" id="competitionLevel" name="competitionLevel" required>
                            <option value="">Pilih Tingkat Kompetisi</option>
                            <?php foreach ($competitionLevels as $id => $level): ?>
                              <option value="<?= $id ?>" <?= (isset($formData['competitionLevel']) && $formData['competitionLevel'] == $id) ? 'selected' : '' ?>>
                                <?= $level['name'] ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionRank">Peringkat Kompetisi <span
                              class="text-danger">*</span></label>
                          <select class="form-control" id="competitionRank" name="competitionRank" required>
                            <option value="">Pilih Peringkat Kompetisi</option>
                            <?php foreach ($competitionRanks as $id => $rank): ?>
                              <option value="<?= $id ?>" <?= (isset($formData['competitionRank']) && $formData['competitionRank'] == $id) ? 'selected' : '' ?>>
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
                          <label class="form-label" for="competitionPlace">Tempat/Penyelenggara Kompetisi <span
                              class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="competitionPlace" name="competitionPlace"
                            value="<?= isset($formData['competitionPlace']) ? htmlspecialchars($formData['competitionPlace']) : '' ?>"
                            placeholder="Tempat Kompetisi dalam Bahasa Indonesia" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionPlaceEnglish">Tempat/Penyelenggara Kompetisi
                            (Bahasa Inggris) <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="competitionPlaceEnglish"
                            name="competitionPlaceEnglish"
                            value="<?= isset($formData['competitionPlaceEnglish']) ? htmlspecialchars($formData['competitionPlaceEnglish']) : '' ?>"
                            placeholder="Tempat Kompetisi dalam Bahasa Inggris" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionUrl">URL Kompetisi <span
                              class="text-danger">*</span></label>
                          <input type="url" class="form-control" id="competitionUrl" name="competitionUrl"
                            value="<?= isset($formData['competitionUrl']) ? htmlspecialchars($formData['competitionUrl']) : '' ?>"
                            placeholder="Alamat Website Kompetisi" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label">Periode Kompetisi <span class="text-danger">*</span></label>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="form-label" for="competitionStartDate">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="competitionStartDate"
                                  name="competitionStartDate"
                                  value="<?= isset($formData['competitionStartDate']) ? htmlspecialchars($formData['competitionStartDate']) : '' ?>"
                                  required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="form-label" for="competitionEndDate">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="competitionEndDate"
                                  name="competitionEndDate"
                                  value="<?= isset($formData['competitionEndDate']) ? htmlspecialchars($formData['competitionEndDate']) : '' ?>"
                                  required>
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
                          <label class="form-label" for="numberOfInstitutions">Jumlah Institusi Peserta <span
                              class="text-danger">*</span></label>
                          <input type="number" class="form-control" id="numberOfInstitutions"
                            name="numberOfInstitutions"
                            value="<?= isset($formData['numberOfInstitutions']) ? htmlspecialchars($formData['numberOfInstitutions']) : '' ?>"
                            placeholder="Total jumlah institusi" min="0" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="numberOfStudents">Jumlah Siswa Peserta <span
                              class="text-danger">*</span></label>
                          <input type="number" class="form-control" id="numberOfStudents" name="numberOfStudents"
                            value="<?= isset($formData['numberOfStudents']) ? htmlspecialchars($formData['numberOfStudents']) : '' ?>"
                            placeholder="Total jumlah siswa" min="1" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="letterNumber">Nomor Surat <span
                              class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="letterNumber" name="letterNumber"
                            value="<?= isset($formData['letterNumber']) ? htmlspecialchars($formData['letterNumber']) : '' ?>"
                            placeholder="Nomor Surat Resmi" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="letterDate">Tanggal Surat <span
                              class="text-danger">*</span></label>
                          <input type="date" class="form-control" id="letterDate" name="letterDate"
                            value="<?= isset($formData['letterDate']) ? htmlspecialchars($formData['letterDate']) : '' ?>"
                            required>
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

                        <div class="form-group mb-3">
                          <label class="form-label" for="letterFile">File Surat <span
                              class="text-danger">*</span></label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="letterFile" name="letterFile"
                              accept=".pdf,.jpeg,.jpg,.png" required>
                            <label class="custom-file-label" for="letterFile">Pilih file</label>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="certificateFile">File Sertifikat <span
                              class="text-danger">*</span></label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="certificateFile" name="certificateFile"
                              accept=".pdf,.jpeg,.jpg,.png" required>
                            <label class="custom-file-label" for="certificateFile">Pilih file</label>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="documentationFile">File Dokumentasi <span
                              class="text-danger">*</span></label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="documentationFile"
                              name="documentationFile" accept=".pdf,.jpeg,.jpg,.png" required>
                            <label class="custom-file-label" for="documentationFile">Pilih file</label>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="posterFile">File Poster <span
                              class="text-danger">*</span></label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="posterFile" name="posterFile"
                              accept=".pdf,.jpeg,.jpg,.png" required>
                            <label class="custom-file-label" for="posterFile">Pilih file</label>
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
                            <div class="input-group mb-2">
                              <select class="form-control dosen-pembimbing" name="supervisors[]">
                                <option value="">Pilih Dosen Pembimbing</option>
                                <?php foreach ($lecturers as $lecturer): ?>
                                  <option value="<?= $lecturer['Id'] ?>" <?= (isset($formData['supervisors']) && in_array($lecturer['Id'], $formData['supervisors'])) ? 'selected' : '' ?>>
                                    <?= $lecturer['FullName'] ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                              <div class="input-group-append">
                                <button type="button" class="btn btn-success"
                                  onclick="achievementForm.addSupervisor()">
                                  <i class="fas fa-plus">+</i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Anggota Tim -->
                        <div class="form-group mb-3">
                          <label class="form-label">Anggota Tim</label>
                          <div id="teamMemberContainer">
                            <div class="input-group mb-2">
                              <select class="form-control anggota-tim" name="teamMembers[]" required>
                                <option value="">Pilih Anggota Tim</option>
                                <?php foreach ($students as $student): ?>
                                  <option value="<?= $student['Id'] ?>" <?= (isset($formData['teamMembers']) && in_array($student['Id'], $formData['teamMembers'])) ? 'selected' : '' ?>>
                                    <?= $student['FullName'] ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                              <select class="form-control anggota-tim-peran" name="teamMemberRoles[]" required>
                                <option value="">Pilih Peran</option>
                                <option value="Ketua" <?= (isset($formData['teamMemberRoles']) && $formData['teamMemberRoles'][0] == 'Ketua') ? 'selected' : '' ?>>Ketua</option>
                                <option value="Anggota" <?= (isset($formData['teamMemberRoles']) && $formData['teamMemberRoles'][0] == 'Anggota') ? 'selected' : '' ?>>Anggota</option>
                                <option value="Personal" <?= (isset($formData['teamMemberRoles']) && $formData['teamMemberRoles'][0] == 'Personal') ? 'selected' : '' ?>>Personal</option>
                              </select>
                              <div class="input-group-append">
                                <button type="button" class="btn btn-success"
                                  onclick="achievementForm.addTeamMember()">
                                  <i class="fas fa-plus">+</i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-12 text-right">
                    <button type="submit" id="submitButton" class="btn btn-primary btn-lg px-4 mr-3">
                      <i class="fas fa-paper-plane mr-2"></i> Kirim
                    </button>
                    <a href="/dashboard/home" class="btn btn-light btn-lg px-4">
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
  window.LECTURER_OPTIONS = `<?php foreach ($lecturers as $lecturer): ?>
        <option value="<?= $lecturer['Id'] ?>"><?= $lecturer['FullName'] ?></option>
  <?php endforeach; ?>`;

  window.STUDENT_OPTIONS = `<?php foreach ($students as $student): ?>
        <option value="<?= $student['Id'] ?>"><?= $student['FullName'] ?></option>
  <?php endforeach; ?>`;

  window.COMPETITION_RANKS = <?= json_encode($competitionRanks) ?>;
  window.COMPETITION_LEVELS = <?= json_encode($competitionLevels) ?>;
</script>

<style>
  body{
    font-family: 'Poppins', sans-serif;
  }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="/assets/css/achievement-submission.css" rel="stylesheet" />
<script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script defer src="/assets/js/achievement-submission.js"></script>
<script defer src="/vendors/js/vendor.bundle.base.js"></script>
<script defer src="/js/off-canvas.js"></script>
<script defer src="/js/hoverable-collapse.js"></script>
<script src="/js/template.js"></script>