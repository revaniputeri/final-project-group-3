<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>
    <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
        <div class="content-wrapper">
            <div class="row pt-5">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h1 class="font-weight-bold">Selamat Datang di PrestaC</h1>
                            <p class="text-muted">Pantau dan kelola prestasi Anda melalui dashboard yang mudah digunakan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Submission Form Menu Box -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card gradient-box">
                        <div class="card-body">
                            <h4 class="card-title" style="color: white;">Tambah Prestasi</h4>
                            <p class="card-description" style="color: white;">
                                Klik disini untuk menambah prestasi baru
                            </p>
                            <a href="/dashboard/achievement/form" class="btn btn-primary btn-lg btn-block">
                                <i class="ti-plus mr-2"></i>
                                Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Kotak Menu Riwayat Prestasi -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="color: white;">Riwayat Prestasi</h4>
                            <p class="card-description" style="color: white;">
                                Lihat riwayat prestasi kamu
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
                            <h4 class="card-title" style="color: white;">Buku Panduan Prestasi</h4>
                            <p class="card-description" style="color: white;">
                                Jangan lupa baca kebijakan dan informasi dibawah!
                            </p>
                            <a href="/dashboard/info" class="btn btn-info btn-lg btn-block">
                                <i class="ti-book mr-2"></i>
                                Baca Buku Panduan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Top 10 Achievement Section -->
            <div class="row mt-4">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body-top">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">10 Prestasi Terhebat Kamu!</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;" class="text-center">No</th>
                                                    <th style="width: 25%;" class="text-center">Nama</th>
                                                    <th style="width: 20%;" class="text-center">Kejuaraan Kompetisi</th>
                                                    <th style="width: 20%;" class="text-center">Tingkat Kompetisi</th>
                                                    <th style="width: 15%;" class="text-center">Total Poin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($topAchievements)) {
                                                    $no = 1;
                                                    foreach ($topAchievements as $achievement) {
                                                ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no++ ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($achievement['CompetitionTitle']) ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($achievement['CompetitionRankName']) ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($achievement['CompetitionLevelName']) ?></td>
                                                            <td class="text-center"><?= number_format($achievement['CompetitionPoints'], 2, ',', '.') ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">Belum ada data prestasi</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card" style="height: 410px;">
                        <div class="card-body-top">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h4 class="card-title">Status Data Prestasi</h4>
                            </div>
                            <div class="row">
                                <div class="chart-container" style="position: relative; height:300px; width:100%;">
                                    <canvas id="doughnutChart" class="chart-canvas" style="max-width: 100%; height: 100%;"></canvas>
                                    <div class="chart-legend mt-2" style="position: absolute; left: 50%; transform: translateX(-50%); display: flex; gap: 20px; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <span style="display: inline-block; width: 12px; height: 12px; background: rgba(255, 215, 0, 0.9); border-radius: 50%;"></span>
                                            PROSES
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <span style="display: inline-block; width: 12px; height: 12px; background: rgba(50, 205, 50, 0.9); border-radius: 50%;"></span>
                                            DITERIMA
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <span style="display: inline-block; width: 12px; height: 12px; background: rgba(220, 20, 60, 0.9); border-radius: 50%;"></span>
                                            DITOLAK
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require __DIR__ . '/partials/footer-page.php'; ?>
    </div>
</div>

<script>
    // document.getElementById('tahun').addEventListener('change', updateTopAchievements);

    // function updateTopAchievements() {
    //     const tahun = document.getElementById('tahun').value;

    //     // Redirect or Ajax call
    //     window.location.href = `/dashboard?tahun=${tahun}`;
    // }

    // Data for the chart
    const statusLabels = ['PROSES', 'DITERIMA', 'DITOLAK'];
    const statusData = [
        <?= $statusCount['PROSES'] ?? 0 ?>,
        <?= $statusCount['DITERIMA'] ?? 0 ?>,
        <?= $statusCount['DITOLAK'] ?? 0 ?>
    ];

    // Ensure the canvas element exists before creating the chart
    const chartCanvas = document.getElementById('doughnutChart');
    if (chartCanvas) {
        const ctx = chartCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    label: 'Jumlah Prestasi: ',
                    data: statusData,
                    backgroundColor: [
                        'rgba(255, 215, 0, 0.9)', // PROSES - vibrant gold
                        'rgba(50, 205, 50, 0.9)', // DITERIMA - vibrant lime green
                        'rgba(220, 20, 60, 0.9)' // DITOLAK - vibrant crimson
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                family: 'Poppins, sans-serif',
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `Jumlah: ${value} prestasi (${percentage}%)`;
                            }
                        }
                    },
                    centerText: {
                        total: statusData.reduce((a, b) => a + b, 0),
                        color: '#000',
                        fontStyle: 'Poppins',
                        sidePadding: 20,
                        lineHeight: 1.2
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            },
            plugins: [{
                id: 'centerText',
                beforeDraw: function(chart) {
                    if (chart.config.options.plugins.centerText) {
                        const width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();

                        ctx.font = `${height / 20}px Poppins, ${chart.config.options.plugins.centerText.fontStyle}`;
                        const labelText = "Total Prestasi";
                        const labelX = Math.round((width - ctx.measureText(labelText).width) / 2);
                        const labelY = height / 2 - 25;
                        ctx.fillText(labelText, labelX, labelY);

                        const total = chart.config.options.plugins.centerText.total;
                        ctx.font = `bold ${height / 6}px Poppins, ${chart.config.options.plugins.centerText.fontStyle}`;
                        ctx.textBaseline = "middle";
                        const totalText = total.toString();
                        const totalX = Math.round((width - ctx.measureText(totalText).width) / 2);
                        const totalY = height / 2 + 15;
                        ctx.fillStyle = chart.config.options.plugins.centerText.color;
                        ctx.fillText(totalText, totalX, totalY);

                        ctx.save();
                    }
                }
            }]
        });
    } else {
        console.error('Chart canvas element not found');
    }
</script>
<style>
    .gradient-box {
        background: linear-gradient(to right, #8490f0, #87b7fd);
        color: white;
        border-radius: 10px;
    }

    .card-body {
        padding: 1.25rem;
        background: linear-gradient(to right, #8490f0, #87b7fd);
        border-radius: 10px;
    }

    .card-body-top {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.25rem;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }
</style>