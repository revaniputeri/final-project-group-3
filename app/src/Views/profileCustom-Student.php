<?php include __DIR__ . '/partials/navbar.php'; ?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <!-- Main Panel -->
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
                        <!-- Ikon Sunting Background -->
                        <i class="fas fa-edit" style="position: absolute; 
                                top: 10px; right: 10px; 
                                font-size: 18px; 
                                color: white; 
                                cursor: pointer; 
                                background: rgba(0, 0, 0, 0.5); 
                                padding: 8px; 
                                border-radius: 50%;" data-bs-toggle="modal"
                            data-bs-target="#changeProfileBackgroundModal"></i>

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
                        <h2 style="font-size: 1.8rem; font-weight: bold; margin: 0; text-align: center;">
                            <?= htmlspecialchars($profile['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                        <p style="font-size: 1rem; font-weight: 500; margin: 10px 0 0; text-align: center;">
                            <?= htmlspecialchars($profile['nim'] ?? 'NIM', ENT_QUOTES, 'UTF-8') ?>
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
                        <form method="POST" action="/dashboard/profile-customization" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="<?= htmlspecialchars($profile['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        value="<?= htmlspecialchars($profile['nim'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?= htmlspecialchars($profile['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan" name="jurusan"
                                        value="<?= htmlspecialchars($profile['jurusan'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        required>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <button type="submit" class="btn btn-primary"
                                    style="border-radius: 8px; font-weight: bold">
                                    Simpan Perubahan
                                </button>
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

        <!-- Modal Ganti Background -->
        <div class="modal fade" id="changeProfileBackgroundModal" tabindex="-1"
            aria-labelledby="changeProfileBackgroundLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeProfileBackgroundLabel">Ganti Background Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/dashboard/update-profile-background" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="newProfileBackground" class="form-label">Pilih Background Baru</label>
                                <input type="file" class="form-control" id="newProfileBackground"
                                    name="profile_background" required>
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