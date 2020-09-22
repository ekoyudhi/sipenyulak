<?php
include "koneksi.php";
include "fungsi.php";

$fungsi = new Fungsi();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'get') {
        //$sql = "SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (5)) AS b ON a.id_penyuluhan = b.id_penyuluhan";
        $sql = "SELECT c.* , d.jml_peserta FROM (SELECT a.*, b.flag FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (5)) AS b ON a.id_penyuluhan = b.id_penyuluhan) AS c LEFT JOIN (SELECT id_penyuluhan, COUNT(id_peserta) AS jml_peserta FROM tb_peserta GROUP BY id_penyuluhan) AS d ON c.id_penyuluhan=d.id_penyuluhan";
        $res = $conn->query($sql);
        $items = array();
        $no = 1;
        while ($row = $res->fetch_object()) {
            $tgl = new Tanggal($row->waktu_penyuluhan);
            $r = array('no' => $no,
                        'nama' => $row->nama_penyuluhan,
                        'lokasi' => $row->lokasi_penyuluhan,
                        'waktu' => $tgl->getTgl().' '.$tgl->getBln(1).' '.$tgl->getThn().' '.$tgl->getJamMenit(),
                        'target' => $row->target_penyuluhan,
                        'tema' => $row->tema_penyuluhan,
                        'anggaran' => $row->anggaran_penyuluhan,
                        'peserta' => $row->jml_peserta,
                        'status' => $fungsi->statusFlag($row->flag),
                        'action' => '<ul class="d-flex justify-content-center">
                        <a class="text-secondary" href="pdf_undangan.php?id='.$row->id_penyuluhan.'" target="_blank" data-toggle="tooltip" title="Cetak PDF">
                        <i class="fa fa-file-pdf-o"></i>
                        </a>
                                    </ul>'     
            );
            array_push($items, $r); 
            $no++; 
        }
        header("Content-type:application/json");
        echo json_encode($items);
    }
} else {
    die('no action');
}


$conn->close();
?>