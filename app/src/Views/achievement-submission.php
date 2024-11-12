<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['error']; ?>
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
              <h4 class="card-title">Achievement Submission Form</h4>
              <p class="card-description">
                Submit your achievement details
              </p>
              <form class="forms-sample" method="POST" action="/dashboard/achievement/form" enctype="multipart/form-data">
                <div class="row">
                  <!-- Left Column -->
                  <div class="col-md-6">
                    <!-- Competition Basic Information -->
                    <div class="card mb-3">
                      <div class="card-body">
                        <h4 class="card-title text-primary mb-4">Basic Information</h4>
                        <div class="form-group">
                            
                          <label for="competitionTitle">Competition Title</label>
                          <input type="text" class="form-control" id="competitionTitle" name="competitionTitle" placeholder="Competition Title in Indonesian">
                        </div>
                        <div class="form-group">
                          <label for="competitionTitleEnglish">Competition Title (English)</label>
                          <input type="text" class="form-control" id="competitionTitleEnglish" name="competitionTitleEnglish" placeholder="Competition Title in English">
                        </div>
                        <div class="form-group">
                          <label for="competitionType">Competition Type</label>
                          <select class="form-control" id="competitionType" name="competitionType">
                            <option value="">Select Competition Type</option>
                            <option value="Sains">Sains</option>
                            <option value="Seni">Seni</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Lain-Lain">Lain-Lain</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="competitionLevel">Competition Level</label>
                          <select class="form-control" id="competitionLevel" name="competitionLevel">
                            <option value="">Select Competition Level</option>
                            <option value="Jurusan">Jurusan</option>
                            <option value="Sekolah">Sekolah</option>
                            <option value="Kecamatan">Kecamatan</option>
                            <option value="Kab/Kota">Kab/Kota</option>
                            <option value="Provinsi">Provinsi</option>
                            <option value="National">National</option>
                            <option value="International">International</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <!-- Competition Details -->
                    <div class="card mb-3">
                      <div class="card-body">
                        <h4 class="card-title text-primary mb-4">Competition Details</h4>
                        <div class="form-group">
                          <label for="competitionPlace">Competition Place/Organizer</label>
                          <input type="text" class="form-control" id="competitionPlace" name="competitionPlace" placeholder="Competition Place in Indonesian">
                        </div>
                        <div class="form-group">
                          <label for="competitionPlaceEnglish">Competition Place/Organizer (English)</label>
                          <input type="text" class="form-control" id="competitionPlaceEnglish" name="competitionPlaceEnglish" placeholder="Competition Place in English">
                        </div>
                        <div class="form-group">
                          <label for="competitionUrl">Competition URL</label>
                          <input type="url" class="form-control" id="competitionUrl" name="competitionUrl" placeholder="Competition Website URL">
                        </div>
                        <div class="form-group">
                          <label>Competition Period</label>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="competitionStartDate">Start Date</label>
                                <input type="date" class="form-control" id="competitionStartDate" name="competitionStartDate">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="competitionEndDate">End Date</label>
                                <input type="date" class="form-control" id="competitionEndDate" name="competitionEndDate">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Right Column -->
                  <div class="col-md-6">
                    <!-- Participation Information -->
                    <div class="card mb-3">
                      <div class="card-body">
                        <h4 class="card-title text-primary mb-4">Participation Information</h4>
                        <div class="form-group">
                          <label for="numberOfInstitutions">Number of Participating Institutions</label>
                          <input type="number" class="form-control" id="numberOfInstitutions" name="numberOfInstitutions" placeholder="Total number of institutions" min="0">
                        </div>
                        <div class="form-group">
                          <label for="numberOfStudents">Number of Participating Students</label>
                          <input type="number" class="form-control" id="numberOfStudents" name="numberOfStudents" placeholder="Total number of students" min="0">
                        </div>
                        <div class="form-group">
                          <label for="letterNumber">Letter Number</label>
                          <input type="text" class="form-control" id="letterNumber" name="letterNumber" placeholder="Official Letter Number">
                        </div>
                        <div class="form-group">
                          <label for="letterDate">Letter Date</label>
                          <input type="date" class="form-control" id="letterDate" name="letterDate">
                        </div>
                      </div>
                    </div>

                    <!-- Supporting Documents -->
                    <div class="card mb-3">
                      <div class="card-body">
                        <h4 class="card-title text-primary mb-4">Supporting Documents</h4>
                        
                        <div class="form-group">
                          <label for="letterFile">Letter File</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="letterFile" name="letterFile">
                            <label class="custom-file-label" for="letterFile">Choose file</label>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="certificateFile">Certificate File</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="certificateFile" name="certificateFile">
                            <label class="custom-file-label" for="certificateFile">Choose file</label>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="documentationFile">Documentation File</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="documentationFile" name="documentationFile">
                            <label class="custom-file-label" for="documentationFile">Choose file</label>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="posterFile">Poster File</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="posterFile" name="posterFile">
                            <label class="custom-file-label" for="posterFile">Choose file</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
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

<!-- Add this JavaScript at the bottom of your file -->
<script>
document.querySelectorAll('.custom-file-input').forEach(input => {
  input.addEventListener('change', function(e) {
    const fileName = this.files[0]?.name || 'Choose file';
    const label = this.nextElementSibling;
    label.textContent = fileName;
  });
});
</script>


