<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <!-- Link Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tambahkan CSS eksternal atau inline jika diperlukan -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Container untuk memposisikan gambar sebagai background */
        .container-fluid {
            position: relative;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("../assets/img/background-pict-login.jpg");
            background-size: cover;  /* Gambar menutupi seluruh layar */
            background-position: center;
            background-repeat: no-repeat;
        }

        .auth-form-light {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;  /* Lebar maksimum dari form */
            padding: 40px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 5vh;
            margin-bottom: 5vh;
            min-height: 650px;
            position: relative;
            z-index: 1; /* Memastikan kotak putih tetap di atas gambar */
            margin-left: 70%;
        }
        /* Khusus bagian kiri form login 
        .right-side{

        }
        */
        .left-side{
            flex: 0;
            background: rgba(255, 255, 255, 0.6);
            width: 675px;
            height: 100%;
            display: block ruby;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 0;
            left: 0;
        }

        .login-vector{
            position: relative;
            max-width: 110%;
            height: auto;
            margin-top: 68px;
            margin-left: 40px;
            transition: transform 0.3s ease;
        }

        .login-vector:hover {
            transform: translateX(-40px);
        }

        .auth-form-light h3 {
            font-size: 24px;
            color: #34495e;
            margin-bottom: 15px;
        }

        .auth-form-light h6 {
            font-size: 15px;
            color: #7f8c8d;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #d1d8e0;
            transition: all 0.3s;
            width: 100%;
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #4facfe;
        }

        .mt-4 {
            margin-top: 2.4rem;
        }

        .btn {
            border-radius: 12px;
            padding: 12px;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            .auth-form-light {
                padding: 30px;
                margin-top: 2vh;
                max-width: 90%;
            }

            .auth-form-light h3 {
                font-size: 24px;
            }

            .auth-form-light h6 {
                font-size: 14px;
            }

            .btn {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="left-side">
        <img src="../assets/img/login-vector.png" alt="Login Vector" class="login-vector">
        </div>
        <div class="right-side">
        <div class="auth-form-light text-left py-3 px-5 px-sm-7">
            <div class="brand-logo text-center mb-4">
                <img src="../assets/img/logo-prestacc.png" alt="logo" 
                     style="width: 200px; height: auto; transition: transform 0.3s; cursor: pointer;" 
                     onmouseover="this.style.transform='scale(1.1)'" 
                     onmouseout="this.style.transform='scale(1)'">
            </div>
            <h3 class="text-center mb-3" style="color: #34495e; font-weight: 700;">
                Selamat Datang
            </h3>
            <h6 class="font-weight-light text-center mb-4" style="color: #7f8c8d;">
                Silahkan masukkan username dan password Anda.
            </h6>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger" style="border-radius: 10px; border: none; font-size: 14px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form class="pt-3" action="/login" method="post" style="margin-top: 0px;">
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="NIM/NIDN/NIP" required 
                           style="border-radius: 12px; border: 1px solid #d1d8e0; padding: 15px; transition: box-shadow 0.3s;">
                    <small class="form-text text-muted ml-2">Masukkan NIM (untuk mahasiswa), NIDN (untuk dosen), atau NIP (untuk admin)</small>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required
                           style="border-radius: 12px; border: 1px solid #d1d8e0; padding: 15px; transition: box-shadow 0.3s;">
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" 
                            style="border-radius: 12px; padding: 12px; background: linear-gradient(to right, #4facfe, #00f2fe); border: none; 
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