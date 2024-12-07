<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <!-- Main Panel -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center pt-5">
                <div class="col-10">
                    <!-- Card Profil -->
                    <div class="card profile-card" style="border-radius: 20px; overflow: hidden; background: linear-gradient(to bottom, #e3f2fd, #ffffff);">
                        <!-- Header -->
                        <div class="profile-header" style="background: linear-gradient(to right, #7b77f4, #7dcef5); padding: 20px; color: white; position: relative; text-align: center;">
                            <img src="<?= $profile['profile_image'] ?? '/path/to/default-image.jpg' ?>" 
                                alt="Profile Picture" 
                                style="border-radius: 10px; width: 120px; height: 120px; object-fit: cover; border: 4px solid white; margin-bottom: -60px;">
                            <h2 style="font-size: 1.8rem; margin-top: 70px;">
                                <?= htmlspecialchars($profile['name'] ?? 'Nama Lengkap', ENT_QUOTES, 'UTF-8') ?>
                            </h2>
                            <p style="font-size: 1rem; font-weight: 500; margin: 0;">
                                <?= htmlspecialchars($profile['nim'] ?? 'NIM', ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>

                        <!-- Content -->
                        <div class="profile-content" style="padding: 20px;">
                            <!-- Info Box -->
                            <div class="row text-center mb-4">
                                <div class="col-6">
                                    <div style="background: linear-gradient(to right, #c5cae9, #ede7f6); padding: 15px; border-radius: 15px; font-weight: bold;">
                                        <h3 style="font-size: 1.5rem; margin: 0;"><?= htmlspecialchars($profile['prestasi'] ?? '0', ENT_QUOTES, 'UTF-8') ?></h3>
                                        <p style="margin: 0;">Prestasi</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="background: linear-gradient(to right, #c5cae9, #ede7f6); padding: 15px; border-radius: 15px; font-weight: bold;">
                                        <h3 style="font-size: 1.5rem; margin: 0;"><?= htmlspecialchars($profile['points'] ?? '0', ENT_QUOTES, 'UTF-8') ?></h3>
                                        <p style="margin: 0;">Point</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulir Profil -->
                            <form method="POST" action="/dashboard/profile-customization" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($profile['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="nim" class="form-label">NIM</label>
                                        <input type="text" class="form-control" id="nim" name="nim" value="<?= htmlspecialchars($profile['nim'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="angkatan" class="form-label">Angkatan</label>
                                        <input type="text" class="form-control" id="angkatan" name="angkatan" value="<?= htmlspecialchars($profile['angkatan'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-12 mb-3">
            <label for="profile_image" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px; font-weight: bold;">
        Simpan Perubahan
    </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include __DIR__ . '/partials/footer-page.php'; ?>
        </div>
    </div>
</div>