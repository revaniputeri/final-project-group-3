<?php include __DIR__ . '/partials/navbar.php'; ?>

<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row pt-5">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h1 class="font-weight-bold">Selamat Datang di Dashboard PrestaC</h1>
                            <p class="text-muted">Pantau dan kelola prestasi Anda melalui dashboard yang mudah digunakan</p>
                            </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Submission Form Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Achievement</h4>
                            <p class="card-description">
                                Click here to add new achievement
                            </p>
                            <a href="/dashboard/achievement/form" class="btn btn-primary btn-lg btn-block">
                                <i class="ti-plus mr-2"></i>
                                Add New
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Achievement History Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Riwayat Prestasi</h4>
                            <p class="card-description">
                                Lihat riwayat prestasi Anda
                            </p>
                            <a href="/dashboard/achievement/history" class="btn btn-info btn-lg btn-block">
                                <i class="ti-list mr-2"></i>
                                Lihat Riwayat
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Achievement Information</h4>
                            <p class="card-description">
                                Check your achievement statistics
                            </p>
                            <a href="/dashboard/achievement/info" class="btn btn-success btn-lg btn-block">
                                <i class="ti-bar-chart mr-2"></i>
                                View Statistics
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>