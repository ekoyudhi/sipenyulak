<?php
session_start();
$nip = $_SESSION['nip'];
include "koneksi.php";
include "fungsi.php";

$fungsi = new Fungsi();
function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$action = $_GET['action'];

if ($action == 'get') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        //$sql = "SELECT a.*, DATE_FORMAT(a.waktu_penyuluhan, '%Y-%m-%dT%H:%i') AS waktu FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (5)) AS b ON a.id_penyuluhan = b.id_penyuluhan WHERE a.id_penyuluhan='$id'";
        $sql = "SELECT a.* FROM tb_penyuluhan AS a INNER JOIN (SELECT * FROM vw_updated_status_penyuluhan WHERE flag IN (5)) AS b ON a.id_penyuluhan = b.id_penyuluhan WHERE a.id_penyuluhan='$id'";
        $res = $conn->query($sql);
        $sql2 = "SELECT * FROM tb_link_feedback WHERE id_penyuluhan='$id'";
        $result2 = $conn->query($sql2);
        $unik_string = '';
        if($result2->num_rows > 0 ) {
            while($row = $result2->fetch_object()) {
                $unik_string = $row->unik_string;
            }
        } else {
            $rnd = generateRandomString(5);
            $sql3 = "INSERT INTO tb_link_feedback VALUES ('$id','$rnd')";
            $result3 = $conn->query($sql3);
            $sql2 = "SELECT * FROM tb_link_feedback WHERE id_penyuluhan='$id'";
            $result2 = $conn->query($sql2);
            while($row = $result2->fetch_object()) {
                $unik_string = $row->unik_string;
            }
        }
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
                        'anggaran' => $row->anggaran_penyuluhan,
                        'link' => $unik_string
                );
                header("Content-type:application/json");
                echo json_encode($r);
            }
        }
    } else {
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
                            'kehadiran' => $kehadiran,
                            'action' =>  $act
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
                        'file' => $row->file_materi,
                        'action' => '<ul class="d-flex justify-content-center">
                                        <li class="mr-3"><a href="#" class="text-danger" data-toggle="modal" data-act="delete" data-id="'.$row->id_penyuluhan.'" data-materi="'.$row->id_materi.'"data-target="#modalMateriDelete"><i class="ti-trash"></i></a></li>
                                    </ul>' 
            );
            array_push($items, $r); 
            $no++; 
        }
        header("Content-type:application/json");
        echo json_encode($items);
    }
} else if ($action == 'insertmateri') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $uploadDir = 'C:\\xampp\\htdocs\\tes'; 
        $response = array( 
            'status' => 0, 
            'message' => 'Form submission failed, please try again.' 
        ); 
        
        // If form is submitted 
        if(isset($_POST['txt-materi']) || isset($_POST['txt-deskripsi']) || isset($_POST['file-materi'])){ 
            // Get the submitted form data 
            $nama = $_POST['txt-materi']; 
            $deskripsi = $_POST['txt-deskripsi']; 
            
            // Check whether submitted data is not empty 
            if(!empty($nama) && !empty($deskripsi)){ 

                $uploadStatus = 1; 
                
                // Upload file 
                $uploadedFile = ''; 
                if(!empty($_FILES["file"]["name"])){ 
                    
                    // File path config 
                    $fileName = basename($_FILES["file"]["name"]); 
                    $targetFilePath = $uploadDir . $fileName; 
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                    
                    // Allow certain file formats 
                    $allowTypes = array('pdf'); 
                    if(in_array($fileType, $allowTypes)){ 
                        // Upload file to the server 
                        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                            $uploadedFile = $fileName; 
                        }else{ 
                            $uploadStatus = 0; 
                            $response['message'] = 'Sorry, there was an error uploading your file.'; 
                        } 
                    }else{ 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, only PDFfiles are allowed to upload.'; 
                    } 
                } 
                
                if($uploadStatus == 1){ 

                    // Insert form data in the database 
                    $sql = "INSERT INTO tb_materi(id_penyuluhan,nama_materi,deskripsi_materi,file_materi,upload_by) VALUES ('$id','$nama', '$deskripsi', '$uploadedFile', $nip)"; 
                    $result = $conn->query($sql);
                    if($result){ 
                        $response['status'] = 1; 
                        $response['message'] = 'Form data submitted successfully!'; 
                    } 
                } 
                
            }else{ 
                $response['message'] = 'Please fill all the mandatory fields (name and email).'; 
            } 
        } 
        
        // Return response 
        echo json_encode($response);
    }
} else if ($action == 'deletemateri') {
    $id_materi = $_POST['id_materi'];
    $sql = "DELETE FROM tb_materi WHERE id_materi='$id_materi'";
    $res = $conn->query($sql);
    if ($res) {
        echo "sukses";
    } else {
        echo "Error tb_materi";
    }
} else if ($action == 'insertpeshadir') {
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
        $last_id = $conn->insert_id;
        //echo "last id tb_penyuluhan : ".$last_id;
        $sql2 = "INSERT INTO tb_presensi VALUES(NULL, '$last_id', $id, 1, NULL)";
        $result2 = $conn->query($sql2);
        if($result2) {
            //echo "last id tb_status_penyuluhan : ".$conn->insert_id;
            echo "sukses";
        } else {
            echo "Error tb_presensi";
        }
        echo "sukses";
    } else {
        echo "Error tb_peserta";
    }
} else if ($action == 'inserthadir') {
    $id = htmlspecialchars($_POST['id']);
    $idpes = htmlspecialchars($_POST['idpes']);
    $sql2 = "INSERT INTO tb_presensi(id_peserta,id_penyuluhan,kehadiran) VALUES($idpes, $id, 1)";
    $result2 = $conn->query($sql2);
    if($result2) {
        echo "sukses";
    } else {
        echo "Error tb_presensi";
    }
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
} else if ($action == 'insertselesai') {
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