<?php include __DIR__ . '/partials/navbar-guest.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/guest.css">
    <link rel="stylesheet" href="path/to/your/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="jumbotron mb-4">
        <div class="right-side">
            <img src="../assets/img/vector-right.png" alt="vector-right" class="login-vector" id="loginVector">
        </div>
        <div class="jumbotron-content">
            <h1 class="jumbotron-title">Welcome to PrestaC</h1>
            <h2 class="jumbotron-subtitle">Sistem Prestasi Mahasiswa</h2><br>
            <h4 class="jumbotron-description" style="max-width: 60%;">
                Selamat datang di PrestaC, platform pencatatan prestasi non-akademik
                mahasiswa Jurusan Teknologi Informasi Politeknik Negeri Malang.
                Tempat untuk mendokumentasikan dan memantau perkembangan
                prestasi dan kegiatan non-akademik.</h4><br>
            <button type="button" class="btn btn-primary jumbotron-button" onclick="scrollToBottom()">Pelajari Lebih lanjut</button>
        </div>
    </div>
    <div id="bottomSection"></div>
    <br>
    <div class="leaderboard">
        <h2 class="leaderboard-title">Leaderboard</h2>
        <div class="podium">
            <?php if (!empty($topThreeAchievements)): ?>
                <?php foreach ([0, 1, 2] as $rank): ?>
                    <?php if (isset($topThreeAchievements[$rank])): ?>
                        <div class="rank <?= ['second', 'first', 'third'][$rank] ?>">
                            <img src="https://api.dicebear.com/9.x/big-smile/svg?seed=<?= urlencode(htmlspecialchars($topThreeAchievements[$rank]['FullName'])) ?>&backgroundType=gradientLinear&backgroundColor=b6e3f4,c0aede,d1d4f9" alt="User <?= $rank + 1 ?>">
                            <?php if ($rank === 0): ?>
                                <div class="medal"></div>
                            <?php endif; ?>
                            <h2><?= htmlspecialchars($topThreeAchievements[$rank]['FullName']) ?></h2>
                            <p class="points"><?= number_format($topThreeAchievements[$rank]['TotalPoints'], 0, ',', '.') ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada data prestasi yang tersedia</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row-mt-4">
        <div class="col-md-12 grid-margin stretch-card px-2 pl-4 pr-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 achievements-header">
                        <h4 class="card-title top-achievements-title">10 Prestasi Tertinggi</h4>
                        <h5 class="card-description mt-2">Periode: <?= date('d M Y', strtotime($currentPeriod['start'])) ?> - <?= date('d M Y', strtotime($currentPeriod['end'])) ?></h5>
                    </div>
                    <div class="table-responsive" style="border-radius: 15px; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);">
                        <table class="table table-striped table-bordered table-hover achievements-table">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="table-header">No</th>
                                    <th class="table-header">Nama</th>
                                    <th class="table-header">Program Studi</th>
                                    <th class="table-header">Total Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($topAchievements)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada data prestasi yang tersedia</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($topAchievements as $index => $achievement): ?>
                                        <tr>
                                            <td class="table-data"><?= $index + 1 ?></td>
                                            <td class="table-data"><?= htmlspecialchars($achievement['FullName']) ?></td>
                                            <td class="table-data"><?= htmlspecialchars($achievement['StudentMajor']) ?></td>
                                            <td class="table-data"><?= number_format($achievement['TotalPoints'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mx-0">
        <div class="col-md-6 grid-margin stretch-card px-2 pl-5">
            <div class="card shadow h-100">
                <div class="card-body d-flex flex-column p-3">
                    <p class="card-title chart-title mb-3">Grafik Prestasi Berdasarkan Tingkat Kategori <?= date('Y') ?></p>
                    <div class="chart-container flex-grow-1">
                        <canvas id="combinedChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card px-2 pr-5">
            <div class="card shadow h-100">
                <div class="card-body d-flex flex-column p-3">
                    <p class="card-title chart-title mb-3">Grafik Trend Poin Kompetisi <?= date('Y') ?></p>
                    <div class="chart-container flex-grow-1">
                        <canvas id="lineChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5 pl-5 pr-5">
        <h2 class="achievements-info-title"> Informasi Prestasi Mahasiswa</h2>
        <div class="row justify-content-center">
            <?php foreach (
                [
                    ['4.jpg', 'Lomba Narrative kategori Indie Game Ignite'],
                    ['2.jpg', 'Juara 1 Infographic Competition IPB'],
                    ['1.jpg', 'COMPFEST UI 16 tahun 2024'],
                    ['3.jpg', 'Medali Emas PIMNAS 37']
                ] as $card
            ): ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card shadow achievement-card">
                        <img src="/assets/img/<?= $card[0] ?>" alt="..." class="card-img-top achievement-image">
                        <div class="card-body text-center">
                            <h4 class="achievement-title"><?= $card[1] ?></h4>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="row mt-5 text-center">
            <div class="col-12" style="border-radius: 10px;">
                <div class="guide-book-card p-4 shadow gradient-box" style="border-radius: 15px;">
                    <h3 class="text-white mb-3 font-weight-bold" style="font-size: 1.5rem; font-family: 'Poppins', sans-serif;">Ingin Raih Prestasi Seperti Mereka?</h3>
                    <p class="text-white mb-4 font-weight-bold" style="font-size: 1.2rem; font-family: 'Poppins', sans-serif;">
                        Download Guide Book PrestaC sekarang untuk berbagai informasi prestasi!
                    </p>
                    <a href="/download/skema-poin" download class="btn btn-light btn-lg" 
                       style="border-radius: 25px; padding: 10px 30px; font-weight: 600; font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-download mr-2"></i>Download Guide Book
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5"></div>

    <script>
        const labels = <?= json_encode($levelChartData['labels']) ?>;
        const kompetisiData = <?= json_encode($levelChartData['values']) ?>;

        const ctx = document.getElementById('combinedChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Poin Kompetisi',
                    data: kompetisiData,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(201, 203, 207, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ],
                    borderColor: ['rgba(255, 255, 255, 1)'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
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
                                return `${label}: ${value} prestasi (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        const lineDataSistemInformasiBisnis = <?= json_encode($monthlyCompetitions['sib'] ?? array_fill(0, 12, 0)) ?>;
        const lineDataTeknikInformatika = <?= json_encode($monthlyCompetitions['ti'] ?? array_fill(0, 12, 0)) ?>;
        const bulan = <?= json_encode($monthlyCompetitions['months'] ?? ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']) ?>;

        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [{
                        label: 'Sistem Informasi Bisnis',
                        data: lineDataSistemInformasiBisnis,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Teknik Informatika',
                        data: lineDataTeknikInformatika,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Poin: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Poin Kompetisi'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        function scrollToBottom() {
            document.getElementById('bottomSection').scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>