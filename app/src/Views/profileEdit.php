<?php include __DIR__ . '/partials/navbar.php'; ?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="/assets/css/profileEdit.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <div class="main-panel" id="mainPanel">
        <div class="content-wrapper">
            <div class="row justify-content-center pt-5">
                <div class="col-10">
                    <!-- Profile Header -->
                    <div class="profile-header gradient-box mx-auto profile-header-container">
                        <div class="profile-picture-container">
                            <div class="profile-picture-wrapper">
                                <?php
                                if (!isset($_SESSION['user']['profile_picture'])) {
                                    $_SESSION['user']['profile_picture'] = 'https://api.dicebear.com/9.x/big-smile/svg?seed=' .
                                        (isset($_SESSION['user']['fullName']) ? urlencode(htmlspecialchars($_SESSION['user']['fullName'])) : 'default') .
                                        '&backgroundType=gradientLinear&backgroundColor=b6e3f4,c0aede,d1d4f9';
                                }
                                ?>
                                <img src="<?= $_SESSION['user']['profile_picture'] ?>" alt="Profile Picture" class="profile-picture">
                            </div>
                        </div>

                        <h2 class="profile-name">
                            <span><?= isset($_SESSION['user']['fullName']) ? htmlspecialchars($_SESSION['user']['fullName']) : '' ?></span>
                        </h2>
                        <p class="profile-username">
                            <span><?= isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username']) : '' ?></span>
                        </p>
                    </div>

                    <!-- Profile Content -->
                    <div class="profile-content mx-auto profile-content-container">
                        <!-- Info Box -->
                        <div class="row text-center mb-4 mt-2">
                            <div class="col-6">
                                <div class="info-card info-card-blue info-card-rounded">
                                    <h3>
                                        <i class="fas fa-trophy"></i>
                                        <?= htmlspecialchars($profile['prestasi'] ?? '0', ENT_QUOTES, 'UTF-8') ?>
                                    </h3>
                                    <p>Total Prestasi</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-card info-card-green info-card-rounded">
                                    <h3>
                                        <i class="fas fa-star"></i>
                                        <?= htmlspecialchars($profile['points'] ?? '0', ENT_QUOTES, 'UTF-8') ?>
                                    </h3>
                                    <p>Total Poin</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="card mx-auto shadow-lg profile-details-card">
                            <div class="card-header gradient-box text-white profile-details-header">
                                <h3 class="card-title mb-0 profile-details-title">Informasi Profil</h3>
                            </div>
                            <div class="card-body profile-details-body">
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label mb-2">Email</label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text bg-light profile-input-icon">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 profile-input-field" id="email"
                                            value="<?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8') ?>"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="jurusan" class="form-label mb-2">Jurusan</label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text bg-light profile-input-icon">
                                            <i class="fas fa-graduation-cap text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 profile-input-field" id="jurusan"
                                            value="<?= htmlspecialchars($profile['studentMajor'], ENT_QUOTES, 'UTF-8') ?>"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="phone" class="form-label mb-2">No. Telepon</label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text bg-light profile-input-icon">
                                            <i class="fas fa-phone text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 profile-input-field" id="phone"
                                            value="<?= htmlspecialchars($profile['phone'], ENT_QUOTES, 'UTF-8') ?>"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="status" class="form-label mb-2">Status</label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text bg-light profile-input-icon">
                                            <i class="fas fa-user-check text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 profile-input-field" id="status"
                                            value="<?= htmlspecialchars($profile['studentStatus'], ENT_QUOTES, 'UTF-8') ?>"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>