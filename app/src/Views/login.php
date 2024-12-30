<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skydash Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/login.css">
</head>

<body>
    <div class="container-fluid">
        <div class="left-side">
            <img src="/assets/img/login-vector.png" alt="Login Vector" class="login-vector">
        </div>
        <div class="right-side">
            <div class="auth-form-light text-left py-3 px-5 px-sm-7">
                <div class="brand-logo text-center mb-4">
                    <img src="../assets/img/prestac-newest.png" alt="logo"
                        style="width: 270px; height: auto; margin-bottom: 40px; transition: transform 0.3s; cursor: pointer;"
                        onmouseover="this.style.transform='scale(1.1)'"
                        onmouseout="this.style.transform='scale(1)'">
                </div>
                <h3 class="text-center mb-3" style="color: #34495e; font-weight: 700;">
                    Selamat Datang
                </h3>
                <h6 class="font-weight-light text-center mb-4" style="color: #7f8c8d;">
                    Silahkan masukkan username dan password Anda.
                </h6>

                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger" style="border-radius: 10px; border: none; font-size: 14px; text-align: center;">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="/login" method="post" style="margin-top: 0px;">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="NIM/NIP" required
                            style="border-radius: 12px; border: 1px solid #d1d8e0; padding: 15px; transition: box-shadow 0.3s;">
                        <small class="form-text text-muted ml-2">Masukkan NIM (untuk mahasiswa) atau NIP (untuk admin)</small>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required
                            style="border-radius: 12px; border: 1px solid #d1d8e0; padding: 15px; transition: box-shadow 0.3s;">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                            style="border-radius: 12px; padding: 12px; background: linear-gradient(to right, #4facfe, #00f2fe); border: none; margin-top: 50px;
                                   box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: all 0.3s;">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>