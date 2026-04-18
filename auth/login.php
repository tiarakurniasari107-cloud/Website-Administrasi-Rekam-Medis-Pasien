<?php
require_once "../config/config.php";
if (isset($_SESSION['user'])) {
    echo "<script>window.location='".base_url()."'</script>";
} else {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login - Administrasi Rekam Medis Klinik</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #0d4f6d;
            --brand-secondary: #0b7c95;
            --brand-accent: #2ba8a0;
            --surface: #ffffff;
            --surface-soft: #f6fbff;
            --ink: #143447;
            --muted: #5f7686;
            --line: #d4e4ee;
            --danger: #b73a4c;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            color: var(--ink);
            font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", sans-serif;
            background: radial-gradient(circle at 8% 12%, #d7f1fa 0%, #eef8fc 35%, #e7f0f7 62%, #e0e9f3 100%);
            position: relative;
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
            filter: blur(3px);
            animation: float-shape 14s ease-in-out infinite;
        }

        body::before {
            width: 340px;
            height: 340px;
            right: -110px;
            top: -80px;
            background: rgba(43, 168, 160, 0.22);
        }

        body::after {
            width: 280px;
            height: 280px;
            left: -90px;
            bottom: -70px;
            background: rgba(13, 79, 109, 0.22);
            animation-delay: -5s;
        }

        .page-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 26px 15px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            width: 100%;
            max-width: 950px;
            border-radius: 22px;
            overflow: hidden;
            background: var(--surface);
            box-shadow: 0 28px 70px rgba(16, 54, 76, 0.22);
            display: flex;
            animation: card-enter .75s ease both;
        }

        .brand-pane {
            width: 43%;
            padding: 38px 34px;
            color: #ffffff;
            background: linear-gradient(155deg, var(--brand-primary) 0%, var(--brand-secondary) 55%, #14958d 100%);
            position: relative;
        }

        .brand-pane::after {
            content: "";
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.06) 12px, transparent 12px, transparent 26px);
            opacity: .6;
            pointer-events: none;
        }

        .brand-content {
            position: relative;
            z-index: 1;
        }

        .brand-chip {
            display: inline-block;
            margin-bottom: 16px;
            padding: 6px 14px;
            border-radius: 999px;
            background-color: rgba(255, 255, 255, 0.2);
            letter-spacing: .6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .brand-title {
            margin: 0;
            font-size: 32px;
            line-height: 1.2;
            font-weight: 700;
        }

        .brand-copy {
            margin: 14px 0 24px;
            font-size: 15px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.9);
        }

        .brand-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .brand-list li {
            padding: 9px 0;
            font-size: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.24);
        }

        .brand-list li:first-child {
            border-top: 0;
            padding-top: 0;
        }

        .form-pane {
            width: 57%;
            padding: 42px 40px;
            background: var(--surface);
        }

        .form-title {
            margin: 0;
            font-size: 27px;
            line-height: 1.2;
            font-weight: 700;
            color: #10374d;
        }

        .form-subtitle {
            margin: 10px 0 28px;
            color: var(--muted);
            font-size: 14px;
        }

        .form-group label {
            font-size: 12px;
            color: #365567;
            letter-spacing: .6px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .input-group-addon {
            background-color: #edf6fb;
            border-color: var(--line);
            color: var(--brand-primary);
        }

        .form-control {
            border-color: var(--line);
            height: 42px;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #66abc7;
            box-shadow: 0 0 0 3px rgba(25, 135, 164, 0.15);
        }

        .btn-login {
            margin-top: 8px;
            border: 0;
            border-radius: 8px;
            padding: 11px 12px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: .4px;
            color: #ffffff;
            background: linear-gradient(120deg, var(--brand-primary), var(--brand-secondary), var(--brand-accent));
            box-shadow: 0 14px 24px rgba(13, 79, 109, 0.24);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .btn-login:hover,
        .btn-login:focus {
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 16px 24px rgba(13, 79, 109, 0.32);
        }

        .helper-text {
            margin: 14px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .alert {
            border: 0;
            border-left: 4px solid var(--danger);
            border-radius: 8px;
        }

        .alert .close {
            opacity: .8;
        }

        @keyframes card-enter {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float-shape {
            0%,
            100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @media (max-width: 991px) {
            .login-card {
                flex-direction: column;
            }

            .brand-pane,
            .form-pane {
                width: 100%;
            }

            .brand-pane {
                padding: 28px 26px;
            }

            .form-pane {
                padding: 30px 26px;
            }

            .brand-title {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .page-shell {
                padding: 14px;
            }

            .brand-pane,
            .form-pane {
                padding: 24px 18px;
            }

            .brand-title {
                font-size: 24px;
            }

            .form-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="login-card">
            <div class="brand-pane">
                <div class="brand-content">
                    <span class="brand-chip">Portal Klinik</span>
                    <h1 class="brand-title">Administrasi Rekam Medis</h1>
                    <p class="brand-copy">Satu halaman akses untuk mengelola data pasien, kunjungan, dan laporan layanan klinik secara terstruktur.</p>
                    <ul class="brand-list">
                        <li><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Dokumentasi pasien lebih cepat dan akurat</li>
                        <li><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Akses sistem aman untuk petugas berwenang</li>
                        <li><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> Monitoring administrasi harian real-time</li>
                    </ul>
                </div>
            </div>
            <div class="form-pane">
                <h2 class="form-title">Masuk ke Dashboard</h2>
                <p class="form-subtitle">Silakan login menggunakan akun petugas administrasi Anda.</p>

                <?php
                if(isset($_POST['login'])) {
                    $user = trim(mysqli_real_escape_string($con, $_POST['user']));
                    $pass = sha1(trim(mysqli_real_escape_string($con, $_POST['pass'])));
                    $sql_login = mysqli_query($con, "SELECT * FROM tb_user WHERE username = '$user' AND password = '$pass' ") or die(mysqli_error($con));
                    if (mysqli_num_rows($sql_login) > 0){
                        $_SESSION['user'] = $user;
                        echo "<script>window.location='".base_url()."'</script>";
                    } else { ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <strong>Login Gagal!</strong> Username atau password salah.
                    </div>
                    <?php
                    }
                }
                ?>

                <form action="" method="POST">
                    <div class="form-group">
                        <label for="user">Username</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
                            <input id="user" type="text" name="user" class="form-control" placeholder="Masukkan username" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pass">Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
                            <input id="pass" type="password" name="pass" class="form-control" placeholder="Masukkan password" required>
                        </div>
                    </div>
                    <button type="submit" name="login" class="btn btn-login btn-block">Login Sekarang</button>
                    <p class="helper-text">Akses hanya diperuntukkan bagi staf klinik yang memiliki otorisasi.</p>
                </form>
            </div>
        </div>
    </div>
<script src="<?=base_url('assets/js/jquery.js') ?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>
<?php
}
?>