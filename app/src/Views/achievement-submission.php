
<div class="container-fluid page-body-wrapper">
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

      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-4">Formulir Pengajuan Prestasi</h4>
              <p class="card-description mb-4">
                Masukkan detail prestasi Anda. Tanda <span class="text-danger">*</span> menandakan wajib diisi.
              </p>

              <form class="forms-sample" method="POST" action="/dashboard/achievement/form" enctype="multipart/form-data">
                <div class="row">
                  <!-- Kolom Kiri -->
                  <div class="col-md-6">
                    <!-- Informasi Dasar Kompetisi -->
                    <div class="card shadow-sm mb-4">
                      <div class="card-body">
                        <h5 class="card-title text-primary mb-4">Informasi Dasar</h5>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionTitle">Judul Kompetisi <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="competitionTitle" name="competitionTitle" placeholder="Judul Kompetisi dalam Bahasa Indonesia" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionTitleEnglish">Judul Kompetisi (Bahasa Inggris) <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="competitionTitleEnglish" name="competitionTitleEnglish" placeholder="Judul Kompetisi dalam Bahasa Inggris" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionType">Jenis Kompetisi <span class="text-danger">*</span></label>
                          <select class="form-control" id="competitionType" name="competitionType" required>
                            <option value="">Pilih Jenis Kompetisi</option>
                            <option value="Sains">Sains</option>
                            <option value="Seni">Seni</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Lain-Lain">Lain-Lain</option>
                          </select>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionLevel">Tingkat Kompetisi <span class="text-danger">*</span></label>
                          <select class="form-control" id="competitionLevel" name="competitionLevel" required>
                            <option value="">Pilih Tingkat Kompetisi</option>
                            <?php foreach ($competitionLevels as $id => $level): ?>
                              <option value="<?= $id ?>"><?= $level['name'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionRank">Peringkat Kompetisi <span class="text-danger">*</span></label>
                          <select class="form-control" id="competitionRank" name="competitionRank" required>
                            <option value="">Pilih Peringkat Kompetisi</option>
                            <?php foreach ($competitionRanks as $id => $rank): ?>
                              <option value="<?= $id ?>"><?= $rank['name'] ?></option>
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
                          <input type="text" class="form-control" id="competitionPlace" name="competitionPlace" placeholder="Tempat Kompetisi dalam Bahasa Indonesia" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionPlaceEnglish">Tempat/Penyelenggara Kompetisi (Bahasa Inggris) <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="competitionPlaceEnglish" name="competitionPlaceEnglish" placeholder="Tempat Kompetisi dalam Bahasa Inggris" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="competitionUrl">URL Kompetisi <span class="text-danger">*</span></label>
                          <input type="url" class="form-control" id="competitionUrl" name="competitionUrl" placeholder="Alamat Website Kompetisi" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label">Periode Kompetisi <span class="text-danger">*</span></label>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="form-label" for="competitionStartDate">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="competitionStartDate" name="competitionStartDate" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="form-label" for="competitionEndDate">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="competitionEndDate" name="competitionEndDate" required>
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
                          <input type="number" class="form-control" id="numberOfInstitutions" name="numberOfInstitutions" placeholder="Total jumlah institusi" min="0" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="numberOfStudents">Jumlah Siswa Peserta <span class="text-danger">*</span></label>
                          <input type="number" class="form-control" id="numberOfStudents" name="numberOfStudents" placeholder="Total jumlah siswa" min="0" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="letterNumber">Nomor Surat <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="letterNumber" name="letterNumber" placeholder="Nomor Surat Resmi" required>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="letterDate">Tanggal Surat <span class="text-danger">*</span></label>
                          <input type="date" class="form-control" id="letterDate" name="letterDate" required>
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
                          <label class="form-label" for="letterFile">File Surat <span class="text-danger">*</span></label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="letterFile" name="letterFile" accept=".pdf,.jpeg,.jpg,.png" required>
                            <label class="custom-file-label" for="letterFile">Pilih file</label>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="certificateFile">File Sertifikat <span class="text-danger">*</span></label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="certificateFile" name="certificateFile" accept=".pdf,.jpeg,.jpg,.png" required>
                            <label class="custom-file-label" for="certificateFile">Pilih file</label>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="documentationFile">File Dokumentasi <span class="text-danger">*</span></label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="documentationFile" name="documentationFile" accept=".pdf,.jpeg,.jpg,.png" required>
                            <label class="custom-file-label" for="documentationFile">Pilih file</label>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label" for="posterFile">File Poster <span class="text-danger">*</span></label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="posterFile" name="posterFile" accept=".pdf,.jpeg,.jpg,.png" required>
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
                              <select class="form-control dosen-pembimbing" name="supervisors[]" required>
                                <option value="">Pilih Dosen Pembimbing</option>
                                <?php foreach ($lecturers as $lecturer): ?>
                                  <option value="<?= $lecturer['Id'] ?>"><?= $lecturer['FullName'] ?></option>
                                <?php endforeach; ?>
                              </select>
                              <div class="input-group-append">
                                <button type="button" class="btn btn-success" onclick="addSupervisor()">
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
                                  <option value="<?= $student['Id'] ?>"><?= $student['FullName'] ?></option>
                                <?php endforeach; ?>
                              </select>
                              <select class="form-control anggota-tim-peran" name="teamMemberRoles[]" required>
                                <option value="">Pilih Peran</option>
                                <option value="Ketua">Ketua</option>
                                <option value="Anggota">Anggota</option>
                              </select>
                              <div class="input-group-append">
                                <button type="button" class="btn btn-success" onclick="addTeamMember()">
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
                    <button type="submit" class="btn btn-primary btn-lg px-4 mr-3">
                      <i class="fas fa-paper-plane mr-2"></i> Kirim
                    </button>
                    <button type="reset" class="btn btn-light btn-lg px-4">
                      <i class="fas fa-undo mr-2"></i> Batal
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
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

  function addSupervisor() {
    const container = document.getElementById('supervisorContainer');
    const newInput = document.createElement('div');
    newInput.className = 'input-group mb-2';
    newInput.innerHTML = `
    <select class="form-control" name="supervisors[]" required>
      <option value="">Pilih Dosen Pembimbing</option>
      <?php foreach ($lecturers as $lecturer): ?>
        <option value="<?= $lecturer['Id'] ?>"><?= $lecturer['FullName'] ?></option>
      <?php endforeach; ?>
    </select>
    <div class="input-group-append">
      <button type="button" class="btn btn-success" onclick="addSupervisor()">
        <i class="fas fa-plus">+</i>
      </button>
    </div>
  `;
    container.appendChild(newInput);
  }

  function addTeamMember() {
    const container = document.getElementById('teamMemberContainer');
    const newInput = document.createElement('div');
    newInput.className = 'input-group mb-2';
    newInput.innerHTML = `
    <select class="form-control" name="teamMembers[]" required>
      <option value="">Pilih Anggota Tim</option>
      <?php foreach ($students as $student): ?>
        <option value="<?= $student['Id'] ?>"><?= $student['FullName'] ?></option>
      <?php endforeach; ?>
    </select>
    <select class="form-control" name="teamMemberRoles[]" required>
      <option value="">Pilih Peran</option>
      <option value="Ketua">Ketua</option>
      <option value="Anggota">Anggota</option>
    </select>
    <div class="input-group-append">
      <button type="button" class="btn btn-success" onclick="addTeamMember()">
        <i class="fas fa-plus">+</i>
      </button>
    </div>
  `;
    container.appendChild(newInput);
  }

  document.addEventListener('DOMContentLoaded', function() {
    const rankSelect = document.getElementById('competitionRank');
    const levelSelect = document.getElementById('competitionLevel');
    const pointsDisplay = document.getElementById('competitionPoints');
    
    const ranks = <?= json_encode($competitionRanks) ?>;
    const levels = <?= json_encode($competitionLevels) ?>;
    
    function calculatePoints() {
        const rankPoints = ranks[rankSelect.value]?.points ?? 0;
        const levelMultiplier = levels[levelSelect.value]?.multiplier ?? 1;
        const totalPoints = rankPoints * levelMultiplier;
        
        pointsDisplay.value = totalPoints.toFixed(1) + ' points';
    }
    
    rankSelect.addEventListener('change', calculatePoints);
    levelSelect.addEventListener('change', calculatePoints);
  });
</script>

<script>
// Store PHP data for JavaScript use
const LECTURER_OPTIONS = <?= json_encode($lecturers) ?>;
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="/assets/css/achievement-submission.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/assets/js/achievement-submission.js"></script>