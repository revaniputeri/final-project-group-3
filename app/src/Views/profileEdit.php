<?php include __DIR__ . '/partials/navbar.php'; ?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
        <div class="content-wrapper">   
            <div class="row justify-content-center pt-5">
                <div class="col-10">
                    <!-- Card Profil -->
                    <div class="profile-header" style="position: relative; 
                            background: linear-gradient(to right, #7b77f4, #7dcef5); 
                            padding: 40px; 
                            color: white; 
                            text-align: center; 
                            border-radius: 20px;">

                        <!-- Container Foto Profil -->
                        <div style="position: relative; 
                                width: 150px; 
                                height: 150px; 
                                margin: 0 auto 20px;">
                            <!-- Foto Profil -->
                            <div style="width: 100%; 
                                height: 100%; 
                                background: white; 
                                border-radius: 50%; 
                                overflow: hidden; 
                                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                                <img src="<?= $profile['profile_image'] ?? '/path/to/default-image.jpg' ?>"
                                    alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <!-- Ikon Kamera -->
                            <i class="fas fa-camera" style="position: absolute; 
                                    bottom: 0px; 
                                    right: 10px; 
                                    font-size: 18px; 
                                    color: white; 
                                    cursor: pointer; 
                                    background: rgba(0, 0, 0, 0.5); 
                                    padding: 5px; 
                                    border-radius: 50%;" data-bs-toggle="modal"
                                data-bs-target="#changeProfilePictureModal"></i>
                        </div>
                        
                        <!-- Nama dan NIM -->
                        <h2 style="font-size: 1.8rem; 
                                font-weight: bold; 
                                margin: 0; 
                                text-align: center;">
                                <span><?= isset($_SESSION['user']['fullName']) ? htmlspecialchars($_SESSION['user']['fullName']) : '' ?></span>
                        </h2>
                        <p style="font-size: 1rem; 
                                font-weight: 500; 
                                margin: 10px 0 0; 
                                text-align: center;">
                                <span><?= isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username']) : '' ?></span>
                        </p>
                    </div>
                
                    <!-- Content -->
                    <div class="profile-content" style="padding: 20px;">
                        <!-- Info Box -->
                        <div class="row text-center mb-4">
                            <div class="col-6">
                                <div style="background: linear-gradient(to right, #c5cae9, #ede7f6); 
                                        padding: 15px; 
                                        border-radius: 15px; 
                                        font-weight: bold;">
                                    <h3 style="font-size: 1.5rem; margin: 0;">
                                        <?= htmlspecialchars($profile['prestasi'] ?? '0', ENT_QUOTES, 'UTF-8') ?>
                                    </h3>
                                    <p style="margin: 0;">Prestasi</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div style="background: linear-gradient(to right, #c5cae9, #ede7f6); 
                                        padding: 15px; 
                                        border-radius: 15px; 
                                        font-weight: bold;">
                                    <h3 style="font-size: 1.5rem; margin: 0;">
                                        <?= htmlspecialchars($profile['points'] ?? '0', ENT_QUOTES, 'UTF-8') ?>
                                    </h3>
                                    <p style="margin: 0;">Point</p>
                                </div>
                            </div>
                        </div>

                        <!-- Formulir Profil -->
                        <form method="GET" action="/profile/view" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="form-control">
                                        <?= htmlspecialchars($student['Email'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <div class="form-control">
                                        <?= htmlspecialchars($student['StudentMajor'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                </div>
                                 <div class="col-6 mb-3">
                                    <label for="email" class="form-label">No. Telepon</label>
                                    <div class="form-control">
                                        <?= htmlspecialchars($student['Phone'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="jurusan" class="form-label">Status</label>
                                    <div class="form-control">
                                        <?= htmlspecialchars($student['StudentStatus'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ganti Foto Profil -->
        <div class="modal fade" id="changeProfilePictureModal" tabindex="-1" aria-labelledby="changeProfilePictureLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeProfilePictureLabel">Ganti Foto Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/dashboard/update-profile-image" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="newProfileImage" class="form-label">Pilih Foto Baru</label>
                                <input type="file" class="form-control" id="newProfileImage" name="profile_image"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>