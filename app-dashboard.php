<?php
include "koneksi.php";
include "fungsi.php";

$fungsi = new Fungsi();
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'gettimeline') {
        $sql = "SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1,2,3,4,5)) AS b ON a.id_penyuluhan = b.id_penyuluhan ORDER BY a.waktu_penyuluhan";
        $res = $conn->query($sql);
        $items = array();
        $no = 1;
        while ($row = $res->fetch_object()) {
            $r = '
                        <div class="timeline-task">
                            <div class="icon bg1">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="tm-title">
                                <h4>'.$row->nama_penyuluhan.'</h4>
                                <span class="time"><i class="ti-time"></i>'.$row->waktu_penyuluhan.'</span>
                            </div>
                            <p>Target '.$row->target_penyuluhan.' Lokasi '.$row->lokasi_penyuluhan.'</p>
                        </div>
                    ';
            array_push($items, $r); 
            $no++; 
        }
        header("Content-type:application/json");
        $result['status'] = 1;
        $result['data'] = $items;
        echo json_encode($result);
    } else if ($action == 'getstatus') {
        $sql = "SELECT flag, COUNT(*) as jml FROM vw_updated_status_penyuluhan GROUP BY flag";
        $res = $conn->query($sql);
        $pending_setuju = 0;
        $setuju = 0;
        $pending_laporan = 0;
        $selesai = 0;
        while($row = $res->fetch_object()) {
            $flag = $row->flag;
            if ($flag == 2 || $flag == 3 || $flag == 4) {
                $pending_setuju += $row->jml;
            } else if ($flag == 5) {
                $setuju += $row->jml;
            } else if ($flag == 6 || $flag ==7) {
                $pending_laporan +=$row->jml;
            } else if( $flag == 8) {
                $selesai = $row->jml;
            }
        }
        $result['data'] = array('pending_setuju' => $pending_setuju,
                                'setuju' => $setuju,
                                'pending_laporan' => $pending_laporan,
                                'selesai' => $selesai);
        header('Content-type:application/json');
        echo json_encode($result);
    } else if ($action == 'getpeserta') {
        $sql = "SELECT wkt, SUM(jml) as jml_total FROM vw_peserta_dash GROUP BY wkt";
        $res = $conn->query($sql);
        $item = array();
        while ($row = $res->fetch_object()) {
            $r = array( 'date' => $row->wkt,
                        'value' => intval($row->jml_total));
            array_push($item, $r);
        }
        header('Content-type:application/json');
        echo json_encode($item);
    }
} else {
    echo "";
}

$conn->close()

?>
