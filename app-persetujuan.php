<?php
include "koneksi.php";
include "fungsi.php";

$fungsi = new Fungsi();

$action = $_GET["action"];

if ($action == 'get') {
    $role = $_GET['role'];

    if ($role == 1) {
        $flag = 2;
    } elseif ($role == 2) {
        $flag = 3;
    } elseif ($role == 3) {
        $flag = 4;
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT a.*, DATE_FORMAT(a.waktu_penyuluhan, '%Y-%m-%dT%H:%i') AS waktu FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1,2,3,4,5,6,7,8)) AS b ON a.id_penyuluhan = b.id_penyuluhan WHERE b.flag='$flag' AND a.id_penyuluhan='$id'";

        $res = $conn->query($sql);
        $item = array();
        if ($res->num_rows > 0) {
            while($row = $res->fetch_object()) {
                $r = array('no' => $row->id_penyuluhan,
                        'nama' => $row->nama_penyuluhan,
                        'lokasi' => $row->lokasi_penyuluhan,
                        'waktu' => $row->waktu,
                        'tema' => $row->tema_penyuluhan,
                        'target' => $row->target_penyuluhan,
                        'anggaran' => $row->anggaran_penyuluhan
                );
                header("Content-type:application/json");
                echo json_encode($r);
            }
        } else {
            header("Content-type:application/json");
            echo json_encode($item);
        }
    } else {
        //$sql = "SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1,2,3,4,5,6,7,8)) AS b ON a.id_penyuluhan = b.id_penyuluhan WHERE b.flag='$flag'";
        $sql = "SELECT c.* , d.jml_peserta FROM (SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1,2,3,4,5,6,7,8)) AS b ON a.id_penyuluhan = b.id_penyuluhan) AS c LEFT JOIN (SELECT id_penyuluhan, COUNT(id_peserta) AS jml_peserta FROM tb_peserta GROUP BY id_penyuluhan) AS d ON c.id_penyuluhan=d.id_penyuluhan WHERE c.flag='$flag'";
        $res = $conn->query($sql);
        $items = array();
        $no = 1;
        while ($row = $res->fetch_object()) {
            $tgl = new Tanggal($row->waktu_penyuluhan);
            $r = array('no' => $no,
                        'nama' => $row->nama_penyuluhan,
                        'lokasi' => $row->lokasi_penyuluhan,
                        'waktu' => $tgl->getTgl().' '.$tgl->getBln(1).' '.$tgl->getThn().' '.$tgl->getJamMenit(),
                        'tema' => $row->tema_penyuluhan,
                        'target' => $row->target_penyuluhan,
                        'peserta' => $row->jml_peserta,
                        'anggaran' => $row->anggaran_penyuluhan,
                        'status' => $fungsi->statusFlag($row->flag),
                        'action' => '<ul class="d-flex justify-content-center">
                                        <li class="mr-3"><a href="#" class="text-secondary" data-toggle="modal" data-act="update" data-id="'.$row->id_penyuluhan.'" data-role="'.$role.'" data-target="#modalFormPersetujuan" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a></li>
                                        <li class="mr-3"><a href="#" class="text-success" data-toggle="modal" data-act="setuju" data-id="'.$row->id_penyuluhan.'" data-role="'.$role.'" data-target="#modalSetujuTolak" data-toggle="tooltip" title="Setuju"><i class="fa fa-thumbs-o-up"></i></a></li>
                                        <li><a href="#" class="text-danger" data-toggle="modal" data-act="tolak" data-id="'.$row->id_penyuluhan.'" data-role="'.$role.'" data-target="#modalSetujuTolak" data-toggle="tooltip" title="Tolak"><i class="fa fa-thumbs-o-down"></i></a></li>
                                    </ul>'           
            );
            array_push($items, $r);
            $no++;
        }
        header("Content-type:application/json");
        echo json_encode($items);
    }
} elseif ($action == 'update') {
    $id = htmlspecialchars($_POST['id']);
    $target = htmlspecialchars($_POST['target']);
    $tema = htmlspecialchars($_POST['tema']);
    $anggaran = htmlspecialchars($_POST['anggaran']);

    $nip = "198610212007101003";
    $sql = "UPDATE tb_penyuluhan SET target_penyuluhan='$target', tema_penyuluhan='$tema', anggaran_penyuluhan='$anggaran' WHERE  id_penyuluhan='$id'";
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_penyuluhan";
    }
} elseif ($action == 'setuju') {
    $id = htmlspecialchars($_POST['id']);
    $nip = htmlspecialchars($_POST['nip']);
    $role = htmlspecialchars($_POST['role']);
    $role += 2;
    $sql = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES('$id', $role, '$nip')";
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_status_penyuluhan";
    }
} elseif ($action == 'tolak') {
    $id = htmlspecialchars($_POST['id']);
    $nip = htmlspecialchars($_POST['nip']);
    $role = htmlspecialchars($_POST['role']);
    if ($role == 3) {
        $sql = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES('$id', 2, '$nip')";
    } else {
        $sql = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES('$id', 1, '$nip')";
    }
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_status_penyuluhan";
    }
}

$conn->close();

?>