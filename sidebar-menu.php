<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="."><img src="assets/images/icon/sipenyulak.png" alt="logo"></a>
        </div>
        <div class="sub-logo">
            Sistem Informasi Penyuluhan Pajak
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="active">
                        <li class="active"><a href="dashboard.php"><i class="ti-dashboard"></i><span>Dashboard</span></a></li>
                    </li>
                    <?php if ($_SESSION['role'] == 8 || $_SESSION['role'] == 9 || $_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
                    echo '<li>';
                    echo    '<a href="javascript:void(0)" aria-expanded="true"><i class="ti-pie-chart"></i><span>Perencanaan</span></a>';
                    echo    '<ul class="collapse">';
                            if ($_SESSION['role'] == 8 || $_SESSION['role'] == 9) {
                                echo '<li><a id="sidebar-perencanaan" href="javascript:void(0)">Perencanaan</a></li>';
                            };
                            if ($_SESSION['role'] == 8 || $_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
                                echo '<li><a id="sidebar-setuju" href="javascript:void(0)">Persetujuan</a></li>';
                            }
                    echo    '</ul>';
                    echo '</li>';
                    }
                    if ($_SESSION['role'] == 8 || $_SESSION['role'] == 9 || $_SESSION['role'] == 4 ) {
                    echo '<li>';
                    echo    '<a href="javascript:void(0)"><i class="ti-palette"></i><span>Pelaksanaan</span></a>';
                    echo    '<ul class="collapse">';
                    echo    '<li><a href="javascript:void(0)" id="sidebar-pelaksanaan">Pelaksanaan</a></li>';
                    echo    '<li><a href="javascript:void(0)" id="sidebar-undangan">Undangan Peserta</a></li>';
                    echo    '</ul>';
                    echo '</li>';
                    }
                    if ($_SESSION['role'] == 8 || $_SESSION['role'] == 9 || $_SESSION['role'] == 3 || $_SESSION['role'] == 4) {
                    echo '<li>';
                    echo    '<a href="javascript:void(0)" aria-expanded="true"><i class="ti-slice"></i><span>Evaluasi</span></a>';
                    echo    '<ul class="collapse">';
                                if ($_SESSION['role'] == 8 || $_SESSION['role'] == 9 || $_SESSION['role'] == 4) {
                    echo        '<li><a href="javascript:void(0)" id="sidebar-laporan">Laporan</a></li>';
                                }
                                if ($_SESSION['role'] == 8 || $_SESSION['role'] == 3) {
                    echo        '<li><a href="javascript:void(0)" id="sidebar-setujulap">Persetujuan Laporan</a></li>';
                                }
                    echo    '</ul>';
                    echo '</li>';
                    }
                    ?>
                    <li>
                        <a href="javascript:void(0)"><i class="ti-map-alt"></i><span>Monitoring</span></a>
                        <ul class="collapse">
                            <li><a href="javascript:void(0)" id="sidebar-monpenyul">Penyuluhan</a></li>
                            <li><a href="javascript:void(0)" id="sidebar-monpatuh">Kepatuhan & Pembayaran</a></li>

                        </ul>
                    </li>
                    <?php if ($_SESSION['role'] == 8) { ?>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layers-alt"></i><span>Menu SuperAdmin</span></a>
                        <ul class="collapse">
                            <li><a href="javascript:void(0)" id=sidebar-role>Role</a></li>
                        </ul>
                    </li>
                    <?php
                    }
                    ?>
                    <li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<style>
    .sub-logo {
        color : #fff;
        font-size : 12px;
        font-family : 'Poppins', sans-serif;
    }
</style>