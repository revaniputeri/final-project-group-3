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
            background-size: cover;  /* Gambar menutupi seluruh layar */
            background-position: center;
            background-repeat: no-repeat;
        }
    
        .right-side{
            flex: 0;
            background: rgba(255, 255, 255, 0.6);
            width: 600px;
            height: 100%;
            display: block ruby;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 0;
            right: 0;
        }

        .login-vector{
            position: relative;
            width: 70%;
            height: auto;
            margin-top: 140px;
            margin-left: 10px;
        }
        
        .leaderboard {
            max-width: 1000px; /* Perbesar max-width untuk leaderboard */
            margin: 50px auto;
            background: rgba(255, 255, 255, 1); /* Warna putih dengan transparansi 80% */
            border-radius: 15px;
            padding: 30px; /* Menambah padding agar lebih luas */
        }

        .podium {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 80px; /* Menambah jarak antar podium */
        }

        .rank {
            text-align: center;
            position: relative;
            padding: 15px; /* Menambah padding untuk ruang lebih besar di sekitar elemen */
        }

        .rank img {
            width: 185px; /* Perbesar ukuran gambar */
            height: 190px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .rank.first img {
            width: 205px; /* Perbesar gambar podium pertama */
            height: 210px;
            border: 5px solid white;
        }

        .rank h2 {
            margin: 15px 0 10px; /* Mengatur margin untuk judul */
            font-size: 1.5em; /* Mengecilkan ukuran font judul */
            font-family: 'Poppins', sans-serif; /* Menggunakan font Poppins */
        }

        .rank .points {
            font-size: 1.4em; /* Mengecilkan ukuran font poin */
            font-weight: bold;
            color: #054676;
            font-family: 'Poppins', sans-serif; /* Menggunakan font Poppins */
        }

        .rank.first .points {
            font-size: 2em; /* Membesarkan poin pada podium pertama */
        }

        .rank p {
            margin: 0;
            font-size: 1.2em; /* Membesarkan ukuran font deskripsi */
            color: #d9d9d9;
        }

        .card {
            background-color: white;
            padding: 0;
            border: none;
        }

        .card-img-top {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .card-body {
            padding: 15px;
        }

        /* Styling untuk container */
        .container-fluid.px-0 {
            background: rgba(255, 255, 255, 1); /* Memberikan latar belakang putih */
            padding: 30px 0; /* Memberikan padding atas dan bawah untuk ruang */
            border-radius: 15px; /* Membuat sudut container menjadi melengkung */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Memberikan bayangan lembut pada container */
        }

        /* Styling untuk h2 */
        h2 {
            font-family: 'Poppins', sans-serif; /* Menggunakan font Poppins */
            font-weight: bold;
            color: #333; /* Warna teks gelap untuk kontras yang baik */
            font-size: 2.5em; /* Membuat teks sedikit lebih besar */
            margin-bottom: 20px; /* Memberikan jarak bawah agar tidak terlalu rapat dengan elemen berikutnya */
        }
    </style>
</head>
<body>

<!-- Pengenalan Halaman PrestaC  -->
<div class="jumbotron">
    <!-- <div class="right-side" style="text-align: right;">
        <img src="../assets/img/vector-right.png" alt="vector-right" class="login-vector">
    </div> -->
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
            <div class="medal">🥇</div>
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

<?php
// Data Mahasiswa
$topAchievements = [    ['CompetitionTitle' => 'Revani Nanda Putri' . '🥇', 'CompetitionLevel' => 'Sistem Informasi Bisnis', 'CompetitionPoints' => 20],
    ['CompetitionTitle' => 'Ahmad Fauzi' . '🥈' , 'CompetitionLevel' => 'Teknik Informatika', 'CompetitionPoints' => 18],
    ['CompetitionTitle' => 'Alya Putri'. '🥉', 'CompetitionLevel' => 'Sistem Informasi Bisnis', 'CompetitionPoints' => 15],
    ['CompetitionTitle' => 'Anisa Rahma', 'CompetitionLevel' => 'Teknik Informatika', 'CompetitionPoints' => 14],
    ['CompetitionTitle' => 'Budi Santoso', 'CompetitionLevel' => 'Teknik Informatika', 'CompetitionPoints' => 10],
    ['CompetitionTitle' => 'Citra Dewi', 'CompetitionLevel' => 'Sistem Informasi Bisnis', 'CompetitionPoints' => 9],
    ['CompetitionTitle' => 'Dian Pratama', 'CompetitionLevel' => 'Teknik Informatika', 'CompetitionPoints' => 8],
    ['CompetitionTitle' => 'Eka Saputra', 'CompetitionLevel' => 'Sistem Informasi Bisnis', 'CompetitionPoints' => 7,5],
    ['CompetitionTitle' => 'Fajar Ramadhan', 'CompetitionLevel' => 'Teknik Informatika', 'CompetitionPoints' => 7],
    ['CompetitionTitle' => 'Gita Purnama', 'CompetitionLevel' => 'Sistem Informasi Bisnis', 'CompetitionPoints' => 6],
    ['CompetitionTitle' => 'Hadi Wijaya', 'CompetitionLevel' => 'Sistem Informasi Bisnis', 'CompetitionPoints' => 5,5],
];

// Ambil 10 data teratas
$topAchievements = array_slice($topAchievements, 0, 10);
?>

<div class="row-mt-4">
    <div class="col-md-12 grid-margin stretch-card">
    <!-- memberikan elemen sebuah gaya visual yang membuatnya terlihat seperti kartu -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4" style="text-align: center;">
                    <h4 class="card-title top-achievements-title">Top 10 Prestasi Tertinggi</h4>
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
                           
                            <?php
                                if (!empty($topAchievements)) {
                                    $no = 1;
                                    foreach ($topAchievements as $achievement) {
                                ?>
                                        <tr>
                                            <td style="text-align: center; font-family: Poppins; font-size: 16px !important;"><?= $no++ ?></td>
                                            <td style="text-align: center; font-family: Poppins; font-size: 16px !important;"><?= htmlspecialchars($achievement['CompetitionTitle']) ?></td>
                                            <td style="text-align: center; font-family: Poppins; font-size: 16px !important;"><?= htmlspecialchars($achievement['CompetitionLevel']) ?></td>
                                            <td style="text-align: center; font-family: Poppins; font-size: 16px !important;"><?= number_format($achievement['CompetitionPoints'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data prestasi</td>
                                    </tr>
                                <?php 
                                } 
                            ?>
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
    const lineDataSistemInformasiBisnis = [50, 70, 55, 40, 30, 20, 10];  // Data for "Sistem Informasi Bisnis"
    const lineDataTeknologiInformasi = [40, 60, 45, 35, 25, 15, 5];     // Data for "Teknologi Informasi"

    const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // Membuat grafik line
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: bulan,
            datasets: [
                {
                    label: 'Sistem Informasi Bisnis',
                    data: lineDataSistemInformasiBisnis,
                    fill: false,
                    borderColor: 'rgba(153, 102, 255, 1)',  // Color for "Sistem Informasi Bisnis"
                    tension: 0.1
                },
                {
                    label: 'Teknologi Informasi',
                    data: lineDataTeknologiInformasi,
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',  // Color for "Teknologi Informasi"
                    tension: 0.1
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
                        text: 'Total Poin'
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
        document.getElementById('bottomSection').scrollIntoView({ behavior: 'smooth' });
    }

</script>