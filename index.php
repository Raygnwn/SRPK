<?php
error_reporting(0);
require 'admin/koneksi.php';
session_start();

if (isset($_SESSION['id_op'])) {
    header("Location: admin/daftar_operator.php");
    exit();
} elseif (isset($_POST['submit'])) {
    $id_op = stripslashes(mysqli_real_escape_string($koneksi, $_POST['username']));
    $userpass = stripslashes(mysqli_real_escape_string($koneksi, $_POST['password']));

    $sql = mysqli_query($koneksi, "SELECT id_op, pass_op FROM tabel_operator WHERE id_op = '$id_op'");
    list($id_op, $pass_op) = mysqli_fetch_array($sql);

    if (mysqli_num_rows($sql) > 0) {
        if (password_verify($userpass, $pass_op)) {
            $_SESSION['id_op'] = $id_op;
            while ($data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama_op, jabatan FROM tabel_operator WHERE id_op = '$id_op'"))) {
                $_SESSION['nama_op'] = $data["nama_op"];
                $_SESSION['jabatan'] = $data["jabatan"];
                break;
            }
            setcookie("id_op", $_SESSION['id_op'], time()+1800);
            /*echo '<script>
            setTimeout(function() {
                swal({
                    title: "Berhasil!",
                    text: "Halaman akan dialihkan\nMohon tunggu sebentar!",
                    type: "success"
                }, function() {
                    window.location = "http://localhost/webk9/admin/daftar_operator.php";
                });
            }, 1000);
            </script>';*/
            header("Location: admin/daftar_operator.php");
            die();
        } else {
            header("Location: index.php?login=gagal1");
        }
    } else {
        header("Location: index.php?login=gagal2");
    }    
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REPEKO</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <script type="text/javascript" src="js/sweetalert.min.js"></script>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <header>
        <div id="header-dalam">
            <nav>
                <a href="#" id="menu-icon"><i class="fa fa-bars"></i></a>
                <a class="logo" href="#tim-dev"><img src="img/tek.png"></a>
                <a id="btn-masuk" href="#">Masuk</a>
                <a href="#daftar">Daftar</a>
            </nav>
        </div>
    </header>

    <div id="modal-masuk" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h1 style="text-align: center;">Masuk</h1>
            </div>
            <div class="modal-body">
                <form method="post" action="" autocomplete="off">
                    <input type="text" name="username" placeholder="ID">
                    <input type="password" name="password" placeholder="Password">
            </div>
            <div class="modal-footer clearfix">
                <div class="col-6 col-12-xs">
                    <button type="submit" name="submit" class="btn-daftar sm">MASUK</button>
                </div>
                </form>
                <!--div class="col-6 col-12-xs">
                    <button class="btn-daftar sm"><i class="fa fa-google fa-fw"></i> Masuk dengan Google+</button>
                </div-->
            </div>
        </div>
    </div>
    <div id="background-apaitu">
        <section id="apaitu">
            <span>
                <!--img src="img/kopi.jpg"-->
                <h1 id="judul">Sistem Rekomendasi Perkebunan Kopi
Berdasarkan Curah Hujan dan Tekanan Udara</h1>
                <h2>Bersama Petani Pintar Perkebunan Kopi Indonesia Menjadi Berkualitas</h2>
            </span>
        </section>
    </div>
    <div id="background-daftar">
        <section id="daftar">
            <span>
                <!--div class="col-6 col-12-lg">
                    <h1>Tertarik?</h1>
                    <p>Ayo daftar sekarang!</p><br>
                    <h2 style="text-align:center; margin-bottom: 20px;">Daftar sebagai</h2>
                    <button id="btn-dft-pengentri" class="btn-daftar btn-dft-pengentri">PENGENTRI</button>
                    <button id="btn-dft-pemantau" class="btn-daftar btn-dft-pemantau">PEMANTAU</button>
                </div-->
                <!-- col-6 col-12-lg -->
                <div style="text-align: center">
                    <h1>Tertarik?</h1>
                    <p>Ayo daftar sekarang!</p><br>
                    <div id="daftar-pengentri">
                        <!--h1>PENGENTRI</h1-->
                        <!--button class="btn-daftar"><i class="fa fa-google fa-fw"></i> Daftar dengan Google+</button>
                        <p>ATAU</p-->
                        <form method="post" action="admin/daftar.php" autocomplete="off">
                            <input type="text" name="id" placeholder="ID" required>
                            <input type="text" name="nm" placeholder="Nama" required>
                            <input type="text" name="alamat" placeholder="Alamat" required>
                            <input type="password" name="pass" placeholder="Password" required>
                            <button class="btn-daftar" name="daftar">DAFTAR</button>
                        </form>
                    </div>
                
                <?php
                if (isset($_GET['daftar'])) {
                    if ($_GET['daftar'] == 'berhasil') {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal(
                            "Success!",
                            "Daftar berhasil.",
                            "success")';
                        echo '}, 1000);</script>';
                    } elseif ($_GET['daftar'] == 'gagal') {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal(
                            "Error!",
                            "Daftar gagal.",
                            "error")';
                        echo '}, 1000);</script>';
                    } else {
                        #nothing
                    }
                } else if (isset($_GET['login'])) {
                    if ($_GET['login'] == 'gagal1') {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal(
                            "Error!",
                            "ID atau Password salah",
                            "error")';
                        echo '}, 1000);</script>';
                    } elseif ($_GET['login'] == 'gagal2') {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal(
                            "Error!",
                            "ID tidak terdaftar.",
                            "error")';
                        echo '}, 1000);</script>';
                    } else {
                        #nothing
                    }
                }
                ?>
                    <div id="daftar-pemantau">
                        <h1>PEMANTAU</h1>
                        <button class="btn-daftar"><i class="fa fa-google fa-fw"></i> Daftar dengan Google+</button>
                        <p>ATAU</p>
                        <form>
                            <input type="text" placeholder="E-mail">
                            <input type="text" placeholder="Password">
                            <button class="btn-daftar">DAFTAR</button>
                        </form>
                    </div>
                </div>
            </span>
        </section>
    </div>
    <div id="background-tim-dev">
        <section id="tim-dev">
            <span>
                <h1>Tim Pengembang</h1>
                <div class="col-4 col-12-sm">
                    <img src="img/bima.png">
                    <h2>Bima Irsa Anantawibawa</h2>
                    <h4>Ditugaskan sebagai programmer untuk web ini.</h4>
                </div>
                <div class="col-4 col-12-sm">
                    <img src="img/satya.png">
                    <h2>Ma'ruf Satya Pradipta</h2>
                    <h4>Ditugaskan sebagai manajer untuk web ini.</h4>
                </div>
                <div class="col-4 col-12-sm">
                    <img src="img/raygun.png">
                    <h2>Ray Gunawan Hidayatullah</h2>
                    <h4>Ditugaskan sebagai analisis untuk web ini.</h4>
                </div>
            </span>
        </section>
    </div>
    <footer id="background-footer">
        <section id="footer">
            <span>
                <h2>Bagikan website kami di media sosialmu!</h2>
                <a href="#" target="_blank"><i class="fa fa-facebook-square"></i></a>
                <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fa fa-google-plus"></i></a>
                <h3>REPEKO &copy; Copyright 2019</h3>
            </span>
        </section>
    </footer></body>
</html>