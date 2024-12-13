<?php include __DIR__ . '/partials/navbar.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<div class="container-fluid page-body-wrapper">
    <?php include __DIR__ . '/partials/sidebar-student.php'; ?>

    <div class="main-panel" id="mainPanel" style="margin-left: 235px;">
        <div class="content-wrapper">
            <div class="row pt-5">
                <!-- Card Container -->
                <div class="col-md-12">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header bg-primary text-white">
                            <h4>Informasi Prestasi Mahasiswa</h4>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <p class="fs-5"><strong>Apa itu Prestasi Mahasiswa?</strong></p>
                            <p class="text-justify">
                                Prestasi mahasiswa adalah penghargaan atau pencapaian yang diraih oleh mahasiswa dalam
                                berbagai bidang,
                                baik akademik maupun non-akademik, seperti kompetisi ilmiah, olahraga, seni, teknologi,
                                hingga kegiatan
                                sosial. Prestasi ini menjadi bukti nyata dari kemampuan, dedikasi, dan kreativitas
                                mahasiswa dalam
                                menghadapi tantangan.
                            </p>
                            <br>
                            <p class="fs-5"><strong>Jenis Prestasi Mahasiswa:</strong></p>
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <img src="/assets/img/sains.jpg" alt="Sains" class="img-fluid rounded">
                                    <p><strong>Sains</strong></p>
                                </div>
                                <div class="col-md-3">
                                    <img src="/assets/img/seni.jpg" alt="Seni" class="img-fluid rounded">
                                    <p><strong>Seni</strong></p>
                                </div>
                                <div class="col-md-3">
                                    <img src="/assets/img/olahraga.jpg" alt="Olahraga" class="img-fluid rounded">
                                    <p><strong>Olahraga</strong></p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <img src="/assets/img/Others.jpg" alt="Lainnya" class="img-fluid rounded">
                                    <p><strong>Lainnya</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card for Achievement Points -->
            <div class="row pt-5">
                <div class="col-md-12">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header bg-primary text-white">
                            <h4>Skema Poin Prestasi Mahasiswa:</h4>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <p><strong>Tingkat Kompetisi dan Poin:</strong></p>
                            <p>
                                Setiap poin yang dikumpulkan dapat digunakan untuk mendapatkan penghargaan atau diakui
                                sebagai kontribusi
                                dalam kegiatan kemahasiswaan.
                            </p>
                            <table class="table table-bordered text-center">
                                <!-- Tabel Tingkat Kompetisi -->
                                <thead class="bg-light">
                                    <tr>
                                        <th colspan="2" class="bg-primary text-white">Tingkat Kompetisi</th>
                                    </tr>
                                    <tr>
                                        <th>Tingkat Kompetisi</th>
                                        <th>Level Kompetisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Internasional</td>
                                        <td>4.0 Poin</td>
                                    </tr>
                                    <tr>
                                        <td>Nasional</td>
                                        <td>3.0 Poin</td>
                                    </tr>
                                    <tr>
                                        <td>Provinsi</td>
                                        <td>2.0 Poin</td>
                                    </tr>
                                    <tr>
                                        <td>Kabupaten/ Kota</td>
                                        <td>1.5 Poin</td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>1.0 Poin</td>
                                    </tr>
                                    <tr>
                                        <td>Sekolah</td>
                                        <td>1.0 Poin</td>
                                    </tr>
                                    <tr>
                                        <td>Jurusan</td>
                                        <td>0.5 Poin</td>
                                    </tr>
                                </tbody>
                            </table><br>

                            <!-- Tabel Poin Berdasarkan Juara -->
                            <table class="table table-bordered text-center">
                                <thead class="bg-light">
                                    <tr>
                                        <th colspan="5" class="bg-primary text-white">Poin Berdasarkan Juara</th>
                                    </tr>
                                    <tr>
                                        <th>Juara 1</th>
                                        <th>Juara 2</th>
                                        <th>Juara 3</th>
                                        <th>Penghargaan</th>
                                        <th>Juara Harapan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3.0 Poin</td>
                                        <td>2.5 Poin</td>
                                        <td>2.0 Poin</td>
                                        <td>1.0 Poin</td>
                                        <td>1.0 Poin</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card for Steps to Add Achievements -->
            <div class="row pt-5">
                <div class="col-md-12">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header bg-primary text-white">
                            <h4>Langkah Menambahkan Prestasi:</h4>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <ol>
                                <li>Isi formulir pengajuan prestasi melalui sistem dengan mengeklik <strong>Tambahkan
                                        Prestasi</strong>.</li>
                                <li>Masukkan detail prestasi sesuai dengan ketentuan.</li>
                                <li>Unggah dokumen pendukung seperti sertifikat, foto kegiatan, atau bukti lainnya.</li>
                                <li>Kirim formulir, kemudian tunggu proses validasi oleh admin.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div><br>
            <!-- Tombol Unduh PDF -->
            <div class="text-center mt-5 mb-5">
                <a href="/app/public/assets/Skema Poin Mahasiswa.pdf" class="btn btn-info btn-lg shadow-lg" download>Unduh PDF</a>
            </div>
            <?php require __DIR__ . '/partials/footer-page.php'; ?>
        </div>
    </div>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>