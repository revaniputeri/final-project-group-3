<?php include __DIR__ . '/partials/navbar-guest.php'; ?>
<!DOCTYPE html>
<html lang="en">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth Selection</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tambahkan CSS eksternal atau inline jika diperlukan -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .jumbotron {
            position: relative;
            height: 93vh;
            display: flex;
            justify-content: left;
            align-items: left;
            background: linear-gradient(to bottom, rgba(106, 90, 205, 2), rgba(255, 255, 255, 1));
            background-size: cover;
            /* Gambar menutupi seluruh layar */
            background-position: center;
            background-repeat: no-repeat;
        }

        .right-side {
            flex: 0;
            /* background: rgba(255, 255, 255, 0.6); */
            width: 900px;
            height: 200%;
            display: block ruby;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 0;
            right: 0;
        }

        .login-vector {
            position: relative;
            width: 70%;
            height: auto;
            margin-top: 140px;
            margin-left: 10px;
        }

        .leaderboard {
            max-width: 1000px;
            /* Perbesar max-width untuk leaderboard */
            margin: 50px auto;
            background: rgba(255, 255, 255, 1);
            /* Warna putih dengan transparansi 80% */
            border-radius: 15px;
            padding: -50px;
            /* Menambah padding agar lebih luas */
        }

        .podium {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            /* Untuk sejajar dari bawah */
            gap: 30px;
            /* Jarak antar podium */
            margin-top: 120px;
        }

        .rank {
            text-align: center;
            width: 170px;
            /* Lebar podium */
            position: relative;
            border-radius: 5px 5px 0 0;
            /* Membuat sudut atas melengkung */
            display: flex;
            /* Aktifkan flexbox */
            flex-direction: column;
            /* Susunan elemen secara vertikal */
            justify-content: center;
            align-items: center;
            /* Posisikan konten di tengah secara horizontal */
            padding-top: 40px;
            /* Memberi ruang untuk gambar di atas podium */
            padding-bottom: 20px;
            /* Memberi ruang di bagian bawah podium */
        }

        .rank.first {
            height: 270px;
            /* Tinggi podium pertama */
            background-color: #FFCE34;
            /* Warna emas */
            display: flex;
            align-items: flex-end;
            justify-content: center;
            border: 5px solid #e6b800;
        }

        .rank.second {
            height: 220px;
            /* Tinggi podium kedua */
            background-color: #C0C0C0;
            /* Warna perak */
            display: flex;
            align-items: flex-end;
            justify-content: center;
            border: 5px solid #a8a8a8;
        }

        .rank.third {
            height: 170px;
            /* Tinggi podium ketiga */
            background-color: #CD7F32;
            /* Warna perunggu */
            display: flex;
            align-items: flex-end;
            justify-content: center;
            border: 5px solid #b0652e;
        }

        .rank img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid white;
            position: absolute;
            top: -60px;
            /* Posisi gambar keluar dari podium */
            left: 50%;
            transform: translateX(-50%);
        }

        .rank h2 {
            text-align: center;
            margin: 10px 0;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
            color: black;
            width: 100%;
        }

        .rank .points {
            font-size: 2em;
            /* Perbesar ukuran angka */
            font-weight: bold;
            color: black;
            margin: 5px 0;
            text-align: center;
            width: 100%;
        }

        .card-img-top {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .card-body {
            padding: 15px;
        }

        .card-title.top-achievements-title {
            font-size: 25px;
            /* Ubah ukuran font */
            font-weight: bold;
            /* Membuat teks tebal */
            color: #3b5998;
            font-family: 'Poppins', sans-serif;
            /* Font yang lebih elegan */
            margin-bottom: 5px;
            /* Memberikan jarak bawah */
        }

        /* Styling untuk container */
        .container-fluid.px-0 {
            background: rgba(255, 255, 255, 1);
            /* Memberikan latar belakang putih */
            padding: 30px 0;
            /* Memberikan padding atas dan bawah untuk ruang */
            border-radius: 15px;
            /* Membuat sudut container menjadi melengkung */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Memberikan bayangan lembut pada container */
        }

        /* Styling untuk h2 */
        h2 {
            font-family: 'Poppins', sans-serif;
            /* Menggunakan font Poppins */
            font-weight: bold;
            color: #333;
            /* Warna teks gelap untuk kontras yang baik */
            font-size: 2.5em;
            /* Membuat teks sedikit lebih besar */
            margin-bottom: 20px;
            /* Memberikan jarak bawah agar tidak terlalu rapat dengan elemen berikutnya */
        }
    </style>
</head>

<body>

    <!-- Pengenalan Halaman PrestaC  -->
    <div class="jumbotron">
        <div class="right-side" style="text-align: right;">
            <img src="../assets/img/vector-right.png" alt="vector-right" class="login-vector">
        </div>
        <div style="text-align: left; margin-top: 4%; padding: 10%; font-family: 'Poppins', sans-serif; color: #fff;">
            <h1 style="font-family: 'Roboto', sans-serif; font-size: 4em; font-weight: 700; color: #fff;">Welcome to PrestaC</h1>
            <h2 style="font-family: 'Poppins', sans-serif; font-size: 3.5em; font-weight: 600; color: #f2f2f2;">Sistem Prestasi Mahasiswa</h2><br>
            <h4 style="font-size: 1.8em; color: #f7f7f7; line-height: 1.5; color: black;">
                Selamat datang di PrestaC, platform untuk menginputkan <br> data prestasi mahasiswa.
                Bergabunglah dengan kami untuk <br> mengelola data prestasi Anda.</h4><br>
            <button type="button" class="btn btn-primary" style="font-size: 1.5em; padding: 10px 20px; background-color: #0066cc; border-color: #0066cc;" onclick="scrollToBottom()">Pelajari Lebih lanjut</button>
            <!-- memanggil fungsi -->
            <div id="bottomSection"></div>
        </div>
    </div>

    <!-- Leaderboard -->
    <div class="leaderboard">
        <h2 style="text-align:center;">Leaderboard</h2>
        <div class="podium">
            <div class="rank second">
                <img src="./assets/img/foto1.jpg" alt="User 2">
                <h2>Ahmad Fauzi</h2>
                <p class="points">18</p>
            </div>
            <div class="rank first">
                <img src="./assets/img/foto1.jpg" alt="User 1">
                <div class="medal"></div>
                <h2>Revani Nanda Putri</h2>
                <p class="points">20</p>
            </div>
            <div class="rank third">
                <img src="./assets/img/foto1.jpg" alt="User 3">
                <h2>Alya Putri</h2>
                <p class="points">15</p>
            </div>
        </div>
    </div>

    <div class="row-mt-4">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4" style="text-align: center;">
                        <h4 class="card-title top-achievements-title">10 Prestasi Tertinggi</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" style="border-radius: 10px; overflow: hidden;">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th style="text-align: center; font-family: Poppins; font-size: 16px !important;">No</th>
                                    <th style="text-align: center; font-family: Poppins; font-size: 16px !important;">Nama</th>
                                    <th style="text-align: center; font-family: Poppins; font-size: 16px !important;">Program Studi</th>
                                    <th style="text-align: center; font-family: Poppins; font-size: 16px !important;">Total Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($topAchievements)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada data prestasi yang tersedia</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($topAchievements as $achievement): ?>
                                        <tr>
                                            <td style="text-align: center; font-family: Poppins; font-size: 16px !important;"><?= $no++ ?></td>
                                            <td style="text-align: center; font-family: Poppins; font-size: 16px !important;"><?= htmlspecialchars($achievement['FullName']) ?></td>
                                            <td style="text-align: center; font-family: Poppins; font-size: 16px !important;"><?= htmlspecialchars($achievement['StudentMajor']) ?></td>
                                            <td style="text-align: center; font-family: Poppins; font-size: 16px !important;"><?= number_format($achievement['CompetitionPoints'], 0, ',', '.') ?></td>
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

    <div class="row mt-4">
        <!-- First chart - combined chart -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title" style="text-align: center">Grafik Total Poin Kompetisi dan Juara</p>
                    <!-- mengakses elemen -->
                    <canvas id="combinedChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Second chart - line chart -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title" style="text-align: center">Grafik Trend Poin Kompetisi (Line)</p>
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <h2 style="text-align: center;"> Informasi Prestasi Mahasiswa</h2>
        <div class="row justify-content-center">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow" style="border-radius: 20px; overflow: hidden; height: 100%;">
                    <img src="/assets/img/4.jpg" alt="..." class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h4 style="font-family: 'Roboto', sans-serif; font-weight: bold; color: #333;">Lomba Narrative kategori Indie Game Ignite</h4>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow" style="border-radius: 20px; overflow: hidden; height: 100%;">
                    <img src="/assets/img/2.jpg" alt="..." class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h4 style="font-family: 'Roboto', sans-serif; font-weight: bold; color: #333;">Juara 1 Infographic Competition IPB</h4>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow" style="border-radius: 20px; overflow: hidden; height: 100%;">
                    <img src="/assets/img/1.jpg" alt="..." class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h4 style="font-family: 'Roboto', sans-serif; font-weight: bold; color: #333;">COMPFEST UI 16 tahun 2024</h4>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow" style="border-radius: 20px; overflow: hidden; height: 100%;">
                    <img src="/assets/img/3.jpg" alt="..." class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h4 style="font-family: 'Roboto', sans-serif; font-weight: bold; color: #333;">Medali Emas PIMNAS 37</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>
    // Labels untuk berbagai kategori kompetisi
    const labels = ['Internasional', 'Nasional', 'Provinsi', 'Kabupaten/Kota', 'Kecamatan', 'Sekolah', 'Jurusan'];

    // Data poin untuk setiap kategori kompetisi
    const kompetisiData = [100, 80, 60, 40, 20, 15, 10]; // Poin yang didapatkan mahasiswa

    // Membuat grafik bar
    const ctx = document.getElementById('combinedChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar', // Menggunakan bar chart untuk visualisasi
        data: {
            labels: labels, // Kategori kompetisi
            datasets: [{
                label: 'Total Poin Kompetisi',
                data: kompetisiData, // Data poin untuk masing-masing kategori
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(201, 203, 207, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 2 // Ketebalan garis batas
            }]
        },
        options: {
            responsive: true, // Grafik responsif untuk berbagai ukuran layar
            plugins: {
                legend: {
                    display: true, // Menampilkan legenda
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
                    beginAtZero: true, // Memulai sumbu Y dari 0
                    title: {
                        display: true,
                        text: 'Total Poin' // Judul sumbu Y
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Kategori Kompetisi' // Judul sumbu X
                    }
                }
            }
        }
    });

    // Data for the two lines (points for each category per month)
    const lineDataSistemInformasiBisnis = [50, 70, 55, 40, 30, 20, 10]; // Data for "Sistem Informasi Bisnis"
    const lineDataTeknikInformatika = [40, 60, 45, 35, 25, 15, 5]; // Data for "Teknik Informatika"

    const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // Membuat grafik line
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: bulan, // Months for the x-axis
            datasets: [{
                    label: 'Sistem Informasi Bisnis',
                    data: lineDataSistemInformasiBisnis,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true, // Area under the line will be filled
                    tension: 0.3 // Smooth out the line curve
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
                        text: 'Bulan'
                    }
                }
            }
        }
    });

    function scrollToBottom() {
        // Scroll smoothly to the bottom section
        document.getElementById('bottomSection').scrollIntoView({
            behavior: 'smooth'
        });
    }
</script>