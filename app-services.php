<?php
include "koneksi.php";

function maskingNama($thing) {
    $r = explode(' ',$thing);
    $res = "";
    foreach($r as $x) {
        $ln = strlen($x);
        if ($ln <= 3) {
            $res = $res.' '.$x;
        } else {
            $w = substr($x,0,3);
            $m = "";
            for($i=0;$i<$ln-3;$i++) {
                $m = $m.'*';
            }
            $res = $res.' '.$w.$m;
        }
    }
    return $res;
}

header('Content-type:application/json');

if (isset($_GET['name']) && isset($_GET['val'])) {
    if ($_GET['name'] == 'npwp') {
        $npwp = $_GET['val'];

        $sql = "SELECT * FROM data_wp WHERE npwp='$npwp'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_object()) {
            $data = array('npwp' => $row->npwp,
                        'nik' => $row->nik,
                        'nama' => maskingNama($row->nama),
                        'alamat' => $row->alamat,
                        'kelurahan' => $row->kel,
                        'kecamatan' => $row->kec,
                        'kota' => $row->kota);
            }
            $result['status'] = 1;
            $result['message'] = 'success';
            $result['data'] = $data;
        } else {
            $result['status'] = 0;
            $result['message'] = 'npwp not exist';
            $result['data'] = NULL;
        }
    } else if ($_GET['name'] == 'nik') {
        $nik = $_GET['val'];
        if ($nik == '3521032110860001') {
            $result['status'] = 0;
            $result['message'] = 'nik not exit';
            $result['data'] = NULL;
        } else {
            $result['status'] = 0;
            $result['message'] = 'nik not exist';
            $result['data'] = NULL;
        }
    }
} else {
    $result['status'] = 0;
    $result['message'] = 'name or val not exist';
    $result['data'] = NULL;
}

echo json_encode($result);
$conn->close();
?>