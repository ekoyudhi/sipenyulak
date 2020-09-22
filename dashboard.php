<?php 
session_start();
if ((isset($_SESSION['logged']) && $_SESSION['logged'] === TRUE) === FALSE) {
    header('Location:login.php');
}
include "fungsi.php";
include "top.php"; 
$fungsi = new Fungsi();
?>
        <div class="main-content">
            <!-- header area start -->
            <?php /*include "header.php";*/ ?>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="breadcrumbs-area clearfix">
                            <h4 id="title-page" class="page-title pull-left">Dashboard</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['nama']; ?><i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="login.php?action=logout">Keluar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div id="main-content" class="main-content-inner">
                <div class="row">
                    <!-- seo fact area start -->
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6 mt-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg1">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">Pending Persetujuan</div>
                                            <h2 id="pending_setuju">2,315</h2>
                                        </div>
                                        <!-- <canvas id="seolinechart1" height="50"></canvas> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg2">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">Disetujui</div>
                                            <h2 id="setuju">3,984</h2>
                                        </div>
                                        <!-- <canvas id="seolinechart2" height="50"></canvas> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <div class="card">
                                    <div class="seo-fact sbg3">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">Pending Laporan</div>
                                            <h2 id="pending_laporan">3,984</h2>
                                            <!-- <canvas id="seolinechart3" height="60"></canvas> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <div class="card">
                                    <div class="seo-fact sbg4">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">Selesai</div>
                                            <h2 id="selesai">3,984</h2>
                                            <!-- <canvas id="seolinechart4" height="60"></canvas> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- seo fact area end -->
                    <!-- Social Campain area start -->
                    <div class="col-lg-4 mt-5">
                        <div class="card">
                            <div class="card-body pb-0">
                                <h4 class="header-title">Identitas</h4>
                                <!-- <div id="socialads" style="height: 245px;"></div> -->
                                <?php 
                                echo "<p>".$_SESSION['jabatan']."</p>";
                                echo "<p>".$_SESSION['es4'].", ".$_SESSION['es3'].", ".$_SESSION['es2']."</p>";
                                echo "<p>role sebagai ".$fungsi->ketRole($_SESSION['role'])."</p>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Social Campain area end -->
                    <!-- Statistics area start -->
                    <div class="col-lg-8 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Statistik Peserta</h4>
                                <div id="user-statistics"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Statistics area end -->
                    <!-- Advertising area start -->
                    <!-- <div class="col-lg-4 mt-5">
                        <div class="card h-full">
                            <div class="card-body">
                                <h4 class="header-title">Statistik Tema</h4>
                                <canvas id="seolinechart8" height="233"></canvas>
                            </div>
                        </div>
                    </div> -->
                    <!-- Advertising area end -->
                    <!-- sales area start -->
                    <!-- <div class="col-xl-9 col-ml-8 col-lg-8 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Statistik Kepatuhan dan Pembayaran</h4>
                                <div id="salesanalytic"></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- sales area end -->
                    <!-- timeline area start -->
                    <!-- <div class="col-xl-3 col-ml-4 col-lg-4 mt-5"> -->
                    <div class="col-lg-4 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Timeline</h4>
                                <div id="timeline" class="timeline-area">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- timeline area end -->
                </div>
            </div>
        </div>
<style>
    .role-item {

    }
</style>

<?php include "bottom.php" ?>

