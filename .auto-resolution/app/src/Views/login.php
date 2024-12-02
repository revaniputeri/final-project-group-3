    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5" style="border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                        <div class="brand-logo text-center mb-4">
                            <img src="../assets/img/logo-prestac.png" alt="logo" style="width: 250px; height: auto; transition: transform 0.3s;">
                        </div>
                        <h3 class="text-center mb-3" style="color: #2d3436; font-weight: 600;">Selamat Datang</h3>
                        <h6 class="font-weight-light text-center mb-4" style="color: #636e72;">Silahkan masukkan username dan password anda.</h6>

                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger" style="border-radius: 10px; border: none;">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form class="pt-3" action="/login" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="NIM/NIDN/NIP" required 
                                    style="border-radius: 10px; border: 1px solid #dfe6e9; padding: 15px; transition: all 0.3s;">
                                <small class="form-text text-muted ml-2">Masukkan NIM (untuk mahasiswa), NIDN (untuk dosen), atau NIP (untuk admin)</small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required
                                    style="border-radius: 10px; border: 1px solid #dfe6e9; padding: 15px; transition: all 0.3s;">
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" 
                                    style="border-radius: 10px; padding: 12px; background: linear-gradient(to right, #3498db, #2980b9); border: none; transition: transform 0.3s;">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>