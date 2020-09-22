<?php
include "koneksi.php";
include "fungsi.php";

$fungsi = new Fungsi();
$action = $_GET['action'];

if ($action == 'get') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT a.*, DATE_FORMAT(a.waktu_penyuluhan, '%Y-%m-%dT%H:%i') AS waktu FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1,2,3,4,5,6,7,8)) AS b ON a.id_penyuluhan = b.id_penyuluhan WHERE a.id_penyuluhan='$id'";
        $res = $conn->query($sql);
        $item = array();
        if ($res->num_rows > 0) {
            
            while($row = $res->fetch_object()) {
                $tgl = new Tanggal($row->waktu_penyuluhan);
                $r = array('no' => $row->id_penyuluhan,
                        'nama' => $row->nama_penyuluhan,
                        'lokasi' => $row->lokasi_penyuluhan,
                        'waktu' => $tgl->getTanggal().' '.$tgl->getJamMenit(),
                        'tema' => $row->tema_penyuluhan,
                        'target' => $row->target_penyuluhan,
                        'anggaran' => $row->anggaran_penyuluhan
                );
                header("Content-type:application/json");
                echo json_encode($r);
            }
        }
    } else {
        //$sql = "SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1,2,3,4,5,6,7,8)) AS b ON a.id_penyuluhan = b.id_penyuluhan";
        $sql = "SELECT c.* , d.jml_peserta FROM (SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (1,2,3,4,5,6,7,8)) AS b ON a.id_penyuluhan = b.id_penyuluhan) AS c LEFT JOIN (SELECT id_penyuluhan, COUNT(id_peserta) AS jml_peserta FROM tb_peserta GROUP BY id_penyuluhan) AS d ON c.id_penyuluhan=d.id_penyuluhan";
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
                        <a class="text-secondary" data-toggle="collapse" href="#" data-id="'.$row->id_penyuluhan.'" data-target="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" data-toggle="tooltip" title="Lihat Detail">
                        <i class="fa fa-search-plus"></i>
                      </a>
                                    </ul>'     
            );
            array_push($items, $r); 
            $no++; 
        }
        header("Content-type:application/json");
        echo json_encode($items);
    }
} else if ($action == "getpeserta") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if (isset($_GET['idpes'])) {
            $idpes = $_GET['idpes'];
            $sql = "SELECT a.*, b.kehadiran FROM tb_peserta AS a LEFT JOIN tb_presensi AS b ON a.id_penyuluhan=b.id_penyuluhan AND a.id_peserta=b.id_peserta WHERE a.id_penyuluhan='$id' AND a.id_peserta='$idpes' ORDER BY a.id_peserta";
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
                while($row = $res->fetch_object()) {
                    $r = array('id' => $id,
                            'id_peserta' => $idpes,
                            'nama' => $row->nama_peserta,
                            'npwp' => $row->npwp_peserta,
                            'nik' => $row->nik_peserta,
                            'alamat' => $row->alamat_jalan,
                            'kelurahan' => $row->alamat_kelurahan,
                            'kecamatan' => $row->alamat_kecamatan,
                            'kota' => $row->alamat_kota
                    );
                }
                header("Content-type:application/json");
                $result['status'] = 1;
                $result['data'] = $r;
                echo json_encode($result);
            } else {
                header("Content-type:application/json");
                $result['status'] = 0;
                $result['data'] = NULL;
                echo json_encode($result);
            }
        } else {
            //$sql = "SELECT * FROM tb_peserta WHERE id_penyuluhan='$id'";
            $sql = "SELECT a.*, b.kehadiran FROM tb_peserta AS a LEFT JOIN tb_presensi AS b ON a.id_penyuluhan=b.id_penyuluhan AND a.id_peserta=b.id_peserta WHERE a.id_penyuluhan='$id' ORDER BY a.id_peserta";
            $res = $conn->query($sql);
            $items = array();
            $no = 1;
            while ($row = $res->fetch_object()) {
                if($row->kehadiran == 1) {
                    $act='';
                    $kehadiran = '<span class="badge badge-pill badge-success">Hadir</span>';
                } else {
                    $act = '<ul class="d-flex justify-content-center">
                    <a class="text-secondary" data-toggle="modal" href="#" data-act="presensi" data-id="'.$row->id_penyuluhan.'" data-pes="'.$row->id_peserta.'" data-target="#modalHadir" data-toggle="tooltip" title="Presensi Hadir"><i class="fa fa-clock-o"></i> Presensi</a></ul>';
                    $kehadiran = "";
                }
                $r = array('no' => $no,
                            'nama' => $row->nama_peserta,
                            'npwp' => $row->npwp_peserta,
                            'nik' => $row->nik_peserta,
                            'alamat' => $row->alamat_jalan.', '.$row->alamat_kelurahan.', '.$row->alamat_kecamatan.', '.$row->alamat_kota,
                            'kehadiran' => $kehadiran
                );
                array_push($items, $r); 
                $no++; 
            }
            header("Content-type:application/json");
            echo json_encode($items);
        }
    }
} else if ($action == "getmateri") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tb_materi WHERE id_penyuluhan='$id'";
        $res = $conn->query($sql);
        $items = array();
        $no = 1;
        while ($row = $res->fetch_object()) {
            $r = array('no' => $no,
                        'nama' => $row->nama_materi,
                        'deskripsi' => $row->deskripsi_materi,
                        'file' => $row->file_materi
                        /*'action' => '<ul class="d-flex justify-content-center">
                                        <li class="mr-3"><a href="#" class="text-danger" data-toggle="modal" data-act="delete" data-id="'.$row->id_penyuluhan.'" data-materi="'.$row->id_materi.'"data-target="#modalMateriDelete"><i class="ti-trash"></i></a></li>
                                    </ul>' */
            );
            array_push($items, $r); 
            $no++; 
        }
        header("Content-type:application/json");
        echo json_encode($items);
    }
} else if ($action == "pesertaall") {
    //$sql = "SELECT npwp_peserta, count(nama_peserta) as jml FROM vw_peserta_hadir GROUP BY npwp_peserta";
    $sql = "SELECT a.*, b.nama FROM (SELECT npwp_peserta, count(nama_peserta) as jml FROM vw_peserta_hadir GROUP BY npwp_peserta) AS a LEFT JOIN data_wp AS b ON a.npwp_peserta=b.npwp";
    $result = $conn->query($sql);
    $item = array();
    $no = 1;
    while ($row = $result->fetch_object()) {
        $r = array ('no' => $no,
                    'npwp' => $row->npwp_peserta,
                    'nama' => $fungsi->maskingNama($row->nama),
                    'jml' => $row->jml,
                    'action' => '<ul class="d-flex justify-content-center">
                                    <li class="mr-3"><a href="#" class="text-secondary" data-toggle="collapse" data-act="update" data-npwp="'.$row->npwp_peserta.'" data-target="#collapsePatuh" data-toggle="tooltip" title="Lihat"><i class="fa fa-search-plus"></i></a></li>
                                </ul>');
        array_push($item, $r);
        $no++;
    }

    header("Content-type:application/json");
    echo json_encode($item);
} else if ($action == 'getfeedback') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tb_feedback WHERE id_penyuluhan='$id'";
        $res = $conn->query($sql);
        $items = array();
        $no = 1;
        while ($row = $res->fetch_object()) {
            $r = array('no' => $no,
                        'feedback' => $row->isi_feedback
            );
            array_push($items, $r); 
            $no++; 
        }
        header("Content-type:application/json");
        echo json_encode($items);
    }
} else if ($action == 'getwp') {
    $npwp = htmlspecialchars($_POST['npwp']);
    $sql = "SELECT * FROM data_wp WHERE npwp='$npwp'";
    $res = $conn->query($sql);
    
    if ($res->num_rows > 0) {
        while($row = $res->fetch_object()) {
            $r = array('npwp' => $row->npwp,
                        'nama' => $fungsi->maskingNama($row->nama),
                        'alamat' => $row->alamat.', '.$row->kel.', '.$row->kec.', '.$row->kota);
        }
        $result['status'] = 1;
        $result['data'] = $r;
    } else {
        $result['status'] = 0;
        $result['data'] = $r;
    }
    header('Content-type:application/json');
    echo json_encode($result);
} else if ($action == 'getbayar') {
    $npwp = htmlspecialchars($_POST['npwp']);
    $sql = "SELECT * FROM tb_setoran WHERE npwp='$npwp'";
    $res = $conn->query($sql);
    $item = array();
    $no=1;
    while($row = $res->fetch_object()) {
        $r = array( 'no' => $no,
                    'kdmap' => $row->kdmap,
                    'kjs' => $row->kjs,
                    'ptmspj' => $row->ptmspj,
                    'jumlah' => $row->jumlah);
        array_push($item, $r);
        $no++;
    }
    header('Content-type:application/json');
    echo json_encode($item);
} else if ($action == 'getspt') {
    $npwp = htmlspecialchars($_POST['npwp']);
    $sql = "SELECT * FROM tb_spt WHERE npwp='$npwp'";
    $res = $conn->query($sql);
    $item = array();
    $no=1;
    while($row = $res->fetch_object()) {
        $r = array( 'no' => $no,
                    'masa' => $row->masa_spt,
                    'status' => $row->status_spt,
                    'jenis' => $row->jenis_spt,
                    'pajak' => $row->kode_jenis_pajak_spt,
                    'nilai' => $row->nilai_spt);
        array_push($item, $r);
        $no++;
    }
    header('Content-type:application/json');
    echo json_encode($item);
}
$conn->close();
?>