<?php
session_start();
include "koneksi.php";
include "fungsi.php";

$fungsi = new Fungsi();
if (isset($_GET['action'])) {
   $action = $_GET['action'];
   if ($action == "get") {
        //$sql = "SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (6)) AS b ON a.id_penyuluhan = b.id_penyuluhan";
        $sql = "SELECT c.* , d.jml_peserta FROM (SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (6)) AS b ON a.id_penyuluhan = b.id_penyuluhan) AS c LEFT JOIN (SELECT id_penyuluhan, COUNT(id_peserta) AS jml_peserta FROM tb_peserta GROUP BY id_penyuluhan) AS d ON c.id_penyuluhan=d.id_penyuluhan";
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
                                        <li class="mr-3"><a href="#" class="text-secondary" data-toggle="modal" data-act="isi" data-id="'.$row->id_penyuluhan.'" data-target="#modalIsiDes" data-toggle="tooltip" title="Isi Deskripsi"><i class="fa fa-edit"></i></a></li>
                                        <!--li class="mr-3"><a href="#" class="text-secondary" data-toggle="modal" data-act="cetak" data-id="'.$row->id_penyuluhan.'" data-target="#modalLaporan" data-toggle="tooltip" title="Cetak PDF"><i class="fa fa-file-pdf-o"></i></a></li-->
                                        <li class="mr-3"><a href="pdf_laporan.php?id='.$row->id_penyuluhan.'&nip='.$_SESSION['nip'].'" target="_blank" class="text-secondary"  data-toggle="tooltip" title="Cetak PDF"><i class="fa fa-file-pdf-o"></i></a></li>
                                        <li><a href="#" class="text-primary" data-toggle="modal" data-act="send" data-id="'.$row->id_penyuluhan.'" data-target="#modalLaporan"data-toggle="tooltip" title="Kirim Persetujuan"><i class="fa fa-send"></i></a></li>
                                    </ul>'            
            );
            array_push($items, $r);
            $no++; 
        }
        header("Content-type:application/json");
        echo json_encode($items);
   } else if ($action == "updatedes") {
       $id = htmlspecialchars($_POST['id']);
       $id_lap = htmlspecialchars($_POST['id_lap']);
       $deskripsi = $_POST['deskripsi'];

       $sql = "SELECT id_laporan FROM tb_laporan WHERE id_penyuluhan='$id'";
       $result = $conn->query($sql);
       if($result->num_rows == 1) {
           $sql2 = "UPDATE tb_laporan SET deskripsi_laporan='$deskripsi' WHERE id_laporan='$id_lap'";
           $result2 = $conn->query($sql2);
           if($result2) {
               echo "sukses";
           } else {
               echo "Error tb_laporan updatexx";
           }
       } else {
           $sql3 = "INSERT INTO tb_laporan(id_penyuluhan,deskripsi_laporan) VALUES ('$id', '$deskripsi')";
           $result3 = $conn->query($sql3);
           if($result3) {
               echo "sukses";
           } else {
               echo "Error tb_laporan insert";
           }
       }
   } else if ($action == "getdes") {
       if (isset($_GET['id'])) {
           $id = $_GET['id'];
           $sql = "SELECT * FROM tb_laporan WHERE id_penyuluhan='$id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    $r = array('id_laporan' => $row->id_laporan,
                                'id_penyuluhan' => $row->id_penyuluhan,
                                'deskripsi' => $row->deskripsi_laporan);
                }
                $res['status'] = 1;
                $res['data'] = $r;
            } else {
                $res['status'] = 0;
                $res['data'] = array();
            }
            header('Content-type:application/json');
            echo json_encode($res);
       }
   } else if ($action == "send") {
        $id = htmlspecialchars($_POST['id']);
        $nip = htmlspecialchars($_POST['nip']);
        $sql = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES('$id', 7, '$nip')";
        $result = $conn->query($sql);
        if($result) {
            echo "sukses";
        } else {
            echo "Error tb_status_penyuluhan";
        }
   }
} else {
    echo "";
}

$conn->close();
?>