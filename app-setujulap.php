<?php
include "koneksi.php";
include "fungsi.php";

$fungsi = new Fungsi();
$action = $_GET['action'];
if ($action == 'get') {

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT a.*, DATE_FORMAT(a.waktu_penyuluhan, '%Y-%m-%dT%H:%i') AS waktu FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (7)) AS b ON a.id_penyuluhan = b.id_penyuluhan WHERE  a.id_penyuluhan='$id'";

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
        //$sql = "SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (7)) AS b ON a.id_penyuluhan = b.id_penyuluhan";
        $sql = "SELECT c.* , d.jml_peserta FROM (SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (7)) AS b ON a.id_penyuluhan = b.id_penyuluhan) AS c LEFT JOIN (SELECT id_penyuluhan, COUNT(id_peserta) AS jml_peserta FROM tb_peserta GROUP BY id_penyuluhan) AS d ON c.id_penyuluhan=d.id_penyuluhan";
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
                        'anggaran' => $row->anggaran_penyuluhan,
                        'peserta' => $row->jml_peserta,
                        'status' => $fungsi->statusFlag($row->flag),
                        'action' => '<ul class="d-flex justify-content-center">
                                        <!--li class="mr-3"><a href="#" class="text-secondary" data-toggle="modal" data-act="cetak" data-id="'.$row->id_penyuluhan.'" data-target="#modalSetujuLapPDF" data-toggle="tooltip" title="Lihat PDF"><i class="fa fa-file-pdf-o"></i></a></li-->
                                        <li class="mr-3"><a href="pdf_laporan.php?id='.$row->id_penyuluhan.'" target="_blank" class="text-secondary"  data-toggle="tooltip" title="Lihat PDF"><i class="fa fa-file-pdf-o"></i></a></li>
                                        <li class="mr-3"><a href="#" class="text-success" data-toggle="modal" data-act="setuju" data-id="'.$row->id_penyuluhan.'" data-target="#modalSetujuLap" data-toggle="tooltip" title="Setuju"><i class="fa fa-thumbs-o-up"></i></a></li>
                                        <li><a href="#" class="text-danger" data-toggle="modal" data-act="tolak" data-id="'.$row->id_penyuluhan.'"  data-target="#modalSetujuLap" data-toggle="tooltip" title="Tolak"><i class="fa fa-thumbs-o-down"></i></a></li>
                                    </ul>'           
            );
            array_push($items, $r);
            $no++;
        }
        header("Content-type:application/json");
        echo json_encode($items);
    }
} elseif ($action == 'setuju') {
    $id = htmlspecialchars($_POST['id']);
    $nip = htmlspecialchars($_POST['nip']);

    $sql = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES('$id', 8, '$nip')";
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_status_penyuluhan";
    }
} elseif ($action == 'tolak') {
    $id = htmlspecialchars($_POST['id']);
    $nip = htmlspecialchars($_POST['nip']);

    $sql = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES('$id', 6, '$nip')";

    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_status_penyuluhan";
    }
}
$conn->close();
?>