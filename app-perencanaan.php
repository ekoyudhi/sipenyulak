<?php
include "koneksi.php";
include "fungsi.php";

$fungsi = new Fungsi();
$action = $_GET["action"];

if ($action == "get") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT a.*, DATE_FORMAT(a.waktu_penyuluhan, '%Y-%m-%dT%H:%i') AS waktu FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1)) AS b ON a.id_penyuluhan = b.id_penyuluhan WHERE a.id_penyuluhan='$id'";
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
        }
    } else {
        $sql = "SELECT c.* , d.jml_peserta FROM (SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1)) AS b ON a.id_penyuluhan = b.id_penyuluhan) AS c LEFT JOIN (SELECT id_penyuluhan, COUNT(id_peserta) AS jml_peserta FROM tb_peserta GROUP BY id_penyuluhan) AS d ON c.id_penyuluhan=d.id_penyuluhan";
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
                                        <li class="mr-3"><a href="#" class="text-secondary" data-toggle="collapse" data-act="update" data-id="'.$row->id_penyuluhan.'" data-target="#collapseCapes" data-toggle="tooltip" title="Peserta"><i class="fa fa-users"></i></a></li>
                                        <li class="mr-3"><a href="#" class="text-secondary" data-toggle="modal" data-act="update" data-id="'.$row->id_penyuluhan.'" data-target="#modalFormPerencanaan" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a></li>
                                        <li class="mr-3"><a href="#" class="text-danger" data-toggle="modal" data-act="delete" data-id="'.$row->id_penyuluhan.'" data-target="#modalFormPerencanaanDelete" data-toggle="tooltip" title="Hapus"><i class="ti-trash"></i></a></li>
										<li class="mr-3"><a class="text-secondary" href="pdf_rencana.php?id='.$row->id_penyuluhan.'" target="_blank" data-toggle="tooltip" title="Cetak PDF"><i class="fa fa-file-pdf-o"></i></li>
                                        <li><a href="#" class="text-primary" data-toggle="modal" data-act="send" data-id="'.$row->id_penyuluhan.'" data-target="#modalFormPerencanaanDelete"data-toggle="tooltip" title="Kirim Persetujuan"><i class="fa fa-send"></i></a></li>
                                    </ul>'            
            );
            array_push($items, $r);
            $no++; 
        }
        header("Content-type:application/json");
        echo json_encode($items);
    }
} else if ($action == 'insert') {
    $nama = htmlspecialchars($_POST['nama']);
    $waktu = htmlspecialchars($_POST['waktu']);
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $target = htmlspecialchars($_POST['target']);
    $tema = htmlspecialchars($_POST['tema']);
    $anggaran = htmlspecialchars($_POST['anggaran']);

    $nip = htmlspecialchars($_POST['nip']);
    $sql = "INSERT INTO tb_penyuluhan(id_penyuluhan, nama_penyuluhan,waktu_penyuluhan,lokasi_penyuluhan,target_penyuluhan, tema_penyuluhan, anggaran_penyuluhan) VALUES(NULL, '$nama', '$waktu', '$lokasi', '$target', '$tema', '$anggaran')";
    $result = $conn->query($sql);
    if($result) {
        $last_id = $conn->insert_id;
        //echo "last id tb_penyuluhan : ".$last_id;
        //$sql2 = "INSERT INTO tb_status_penyuluhan VALUES(NULL, '$last_id', 1, '$nip', NULL)";
        $sql2 = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES ('$last_id', 1, '$nip')";
        $result2 = $conn->query($sql2);
        if($result2) {
            //echo "last id tb_status_penyuluhan : ".$conn->insert_id;
            echo "sukses";
        } else {
            echo "Error tb_status_pelayanan".$last_id;
        }
    } else {
        echo "Error tb_penyuluhan 1";
    }
} else if ($action == "update") {
    $id = htmlspecialchars($_POST['id']);
    $nama = htmlspecialchars($_POST['nama']);
    $waktu = htmlspecialchars($_POST['waktu']);
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $target = htmlspecialchars($_POST['target']);
    $tema = htmlspecialchars($_POST['tema']);
    $anggaran = htmlspecialchars($_POST['anggaran']);

    $nip = htmlspecialchars($_POST['nip']);
    $sql = "UPDATE tb_penyuluhan SET nama_penyuluhan='$nama', waktu_penyuluhan='$waktu', lokasi_penyuluhan='$lokasi', target_penyuluhan='$target', tema_penyuluhan='$tema', anggaran_penyuluhan='$anggaran' WHERE  id_penyuluhan='$id'";
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_status_penyuluhan";
    }

} else if ($action == "delete") {
    $id = htmlspecialchars($_POST['id']);
    //$sql = "UPDATE tb_status_penyuluhan SET flag='9' WHERE id_";
    $nip = htmlspecialchars($_POST['nip']);
    $sql = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES('$id', 9, '$nip')";
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_status_penyuluhan";
    }
} else if ($action == "send") {
    $id = htmlspecialchars($_POST['id']);
    $nip = htmlspecialchars($_POST['nip']);
    $sql = "INSERT INTO tb_status_penyuluhan(id_penyuluhan,flag,action_by) VALUES('$id', 2, '$nip')";
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_status_penyuluhan";
    }
} else if ($action == 'getcapes') {
    if (isset($_GET['id'])) {
        if (isset($_GET['idpes'])) {
            $id = $_GET['id'];
            $idpes = $_GET['idpes'];
            $sql = "SELECT * FROM tb_peserta WHERE id_penyuluhan='$id' AND id_peserta='$idpes'";
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
                while($row = $res->fetch_object()) {
                    $r = array('id' => $row->id_penyuluhan,
                            'idpes' => $row->id_peserta,
                            'nama' => $row->nama_peserta,
                            'npwp' => $row->npwp_peserta,
                            'nik' => $row->nik_peserta,
                            'alamat' => $row->alamat_jalan,
                            'kelurahan' => $row->alamat_kelurahan,
                            'kecamatan' => $row->alamat_kecamatan,
                            'kota' => $row->alamat_kota
                    );
                    header("Content-type:application/json");
                    echo json_encode($r);
                }
            } else {
                header("Content-type:application/json");
                echo json_encode(array());
            }
        } else {
            $id = $_GET['id'];
            $sql = "SELECT * FROM tb_peserta WHERE id_penyuluhan='$id'";
            $res = $conn->query($sql);
            $items = array();
            $no = 1;
            while ($row = $res->fetch_object()) {
                $r = array('no' => $no,
                            'nama' => $row->nama_peserta,
                            'npwp' => $row->npwp_peserta,
                            'nik' => $row->nik_peserta,
                            'alamat' => $row->alamat_jalan,
                            'kelurahan' => $row->alamat_kelurahan,
                            'kecamatan' => $row->alamat_kecamatan,
                            'kota' => $row->alamat_kota,
                            'action' => '<ul class="d-flex justify-content-center">
                                            <li class="mr-3"><a href="#" class="text-danger" data-toggle="modal" data-act="deletecapes" data-id="'.$id.'" data-capes="'.$row->id_peserta.'" data-target="#modalCapesHapus" data-toggle="tooltip" title="Hapus"><i class="ti-trash"></i></a></li>
                                        </ul>'
                );
                array_push($items, $r); 
                $no++; 
            }
            header("Content-type:application/json");
            echo json_encode($items);
        }
    } else {
        header("Content-type:application/json");
        echo json_encode(array());
    }
} else if ($action == 'insertcapes') {
    $id = htmlspecialchars($_POST['id']);
    $npwp = htmlspecialchars($_POST['npwp']);
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($_POST['nama']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $kelurahan = htmlspecialchars($_POST['kelurahan']);
    $kecamatan = htmlspecialchars($_POST['kecamatan']);
    $kota = htmlspecialchars($_POST['kota']);

    $sql = "INSERT INTO tb_peserta(id_penyuluhan,npwp_peserta,nik_peserta,nama_peserta,alamat_jalan,alamat_kelurahan,alamat_kecamatan,alamat_kota) VALUES('$id','$npwp','$nik','$nama','$alamat','$kelurahan','$kecamatan','$kota')";
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_peserta";
    }
} else if ($action == 'deletecapes') {
    $idpes = htmlspecialchars($_POST['idpes']);

    $sql = "DELETE FROM tb_peserta WHERE id_peserta='$idpes'";
    $result = $conn->query($sql);
    if($result) {
        echo "sukses";
    } else {
        echo "Error tb_peserta";
    }
} else if ($action == 'getpenyuluhan') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT id_penyuluhan, nama_penyuluhan FROM tb_penyuluhan WHERE id_penyuluhan='$id'";
        $result = $conn->query($sql);
        $item = array();
        if ($result) {
            while($row = $result->fetch_object()) {
                $r = array('id'=>$row->id_penyuluhan,
                            'nama' => $row->nama_penyuluhan);
            }
            $res['data'] = $r;
        } else {
            $res['data'] = array();
        }
        header('Content-type:application/json');
        echo json_encode($res);
    } else {
        die('no id');
    }
    
}
$conn->close();
?>