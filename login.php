<?php
session_start();
include "koneksi.php";
$error="";
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {

    $user = $_POST['user'];
    $pass = $_POST['password'];

    //sql login
    $sql = " SELECT * FROM vw_user_pegawai_role WHERE user='$user' AND pass='$pass'";
    $result = $conn->query($sql);
    if($result->num_rows == 1) {
        
        $nip = '';
        $nama = '';
        $role = '';
        $jabatan='';
        $es4='';
        $es3='';
        $es2='';
        while($row = $result->fetch_object()) {
            $nip = $row->nip;
            $nama = $row->nama;
            $role = $row->role;
            $jabatan = $row->nama_jabatan;
            $es4 = $row->nama_unit_es_4;
            $es3 = $row->nama_unit_es_3;
            $es2 = $row->nama_unit_es_2;
        }
        
        $_SESSION['nip'] = $nip;
        $_SESSION['role'] = $role;
        $_SESSION['nama'] = $nama;
        $_SESSION['jabatan'] = $jabatan;
        $_SESSION['es4'] = $es4;
        $_SESSION['es3'] = $es3;
        $_SESSION['es2'] = $es2;
        $_SESSION['logged'] = TRUE;
    
        header('Location:dashboard.php');
    } else {
        $error = '<div class="alert alert-danger" role="alert">Username atau Password Salah!!!</div>';
    }
    $conn->close();

} else {
    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        session_unset();
        // destroy the session
        session_destroy();
    } else {
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === TRUE) {
            header('Location:dashboard.php');
        }
    }
    
}
?>

<!doctype html>
<html class="no-js" lang="en">

<?php include "header.php"; ?>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-bg">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST">
                    <div class="login-form-head">
                        <h4>Sistem Informasi Penyuluhan Pajak</h4>
                        <!-- <p>Halo, silakan login menggunakan SIKKA</p> -->
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="txt-user">Username</label>
                            <input type="user" name="user" id="user">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="txt-password">Password</label>
                            <input type="password" name="password" id="password">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="submit-btn-area">
                        <?php echo $error; ?>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <?php include "footer.php"; ?>