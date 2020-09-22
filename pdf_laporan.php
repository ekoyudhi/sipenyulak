<?php
session_start();
if (isset($_SESSION['logged'])) {
    
} else {
    die('no session');
}
require('plugin/justification.php');
include "koneksi.php";
include "fungsi.php";

$id = '';
$nip = 'xx';
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (isset($_GET['nip'])) {
        $nip = $_GET['nip'];
        }
    } else {
        die('id or nip not set');
    }
} else {
    die('method not get');
}

function identitas($pdf, $field, $data, $margin, $startH) {
    $idx = 0;
    $height = 8;
    foreach($data as $d) {
        $pdf->SetXY($margin,$startH);
        $pdf->Write(4,($idx+1).".  ".$field[$idx]);
        $pdf->SetXY($margin+50,$startH);
        $pdf->Write(4,":");
        $pdf->SetXY($margin+60,$startH);
        $pdf->Write(4,$d);
        $idx++;
        $startH += $height;
    }
    return $pdf;
}

function peserta($pdf, $data, $margin, $startH) {
    $idx=0;
    $height = 6;
    $pdf->SetFont('Arial','B',11);
    $pdf->SetXY($margin,$startH);
    $pdf->Cell(10,$height,"No",1,0,'C');
    $pdf->SetXY($margin+10,$startH);
    $pdf->Cell(60,$height,"Nama Peserta",1,0,'C');
    $pdf->SetXY($margin+70,$startH);
    $pdf->Cell(38,$height,'NPWP Peserta',1,0,'C');
    //$pdf->SetXY($margin+108,$startH);
    //$pdf->Cell(38,$height,'NIK Peserta',1,0,'C');
    $pdf->SetXY($margin+108,$startH);
    $pdf->Cell(15,$height,'Ket',1,0,'C');
    $startH += $height;
    $pdf->SetFont('Arial','',10);
    foreach($data as $d) {
        if($pdf->GetY() > 265) {
            $pdf->AddPage();
            $startH = 20;
        }
        $pdf->SetXY($margin,$startH);
        $pdf->Cell(10,$height,($idx+1),1,0,'C');
        $pdf->SetXY($margin+10,$startH);
        $pdf->Cell(60,$height,$d['nama'],1);
        $pdf->SetXY($margin+70,$startH);
        $pdf->Cell(38,$height,$d['npwp'],1);
        //$pdf->SetXY($margin+108,$startH);
        //$pdf->Cell(38,$height,$d['nik'],1);
        $pdf->SetXY($margin+108,$startH);
        $pdf->Cell(15,$height,$d['ket'],1,0,'C');
        $idx+=1;
        $startH += $height;
    }
    return $pdf;
}

function tandatangan($pdf, $petugas, $ep, $kakap, $margin, $startH) {
    if($pdf->GetY()-40 >= 220) {
        $pdf->AddPage();
        $startH = 20;
    }
    $height = 6;
    //Jabatan
    $pdf->SetXY($margin,$startH);
    $pdf->Cell(60,$height,"Kepala Kantor,");
    $pdf->SetXY($margin+60,$startH);
    $pdf->Cell(60,$height,'');
    $pdf->SetXY($margin+120,$startH);
    $pdf->Cell(38,$height,'Pembuat Laporan,');

    //nama pejabat
    $startH +=30;

    $pdf->SetXY($margin,$startH);
    $pdf->Cell(60,$height,$kakap);
    $pdf->SetXY($margin+60,$startH);
    $pdf->Cell(60,$height,"");
    $pdf->SetXY($margin+120,$startH);
    $pdf->Cell(38,$height,$petugas);
    return $pdf;
}

function feedback($pdf, $data, $margin, $startH) {
    $height = 4;
    foreach($data as $d) {
        $pdf->SetXY($margin,$pdf->GetY()+$height);
        $pdf->Justify($d['feedback'],160,4);
        //$pdf->Write($height,$d['feedback']);
        //$pdf->Ln();
        $startH +=$height;
    }
    return $pdf;
}

$sql = "SELECT * FROM tb_penyuluhan WHERE id_penyuluhan='$id'";
$result = $conn->query($sql);
//$rows = $result->fetch_all(MYSQLI_ASSOC);
$rows = array();
while($row = $result->fetch_assoc()) {
	array_push($rows, $row);
}

$pdf=new PDF();
$pdf->AddPage(); 
$pdf->setSourceFile('assets/pdf/template.pdf'); 
$tplIdx = $pdf->importPage(1); 
$pdf->useTemplate($tplIdx);
//kop surat
$pdf->setXY(26,24);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(185,5,"KANTOR PELAYANAN PAJAK PRATAMA X",0,1,'C');
$pdf->setXY(26,28);
$pdf->SetFont('Arial','',7);
$pdf->Cell(185,4,"Jalan Kusuma Bangsa Nomor 27 Jakarta",0,1,'C');
//badan surat
$margin = 25.4;
$main = 160;
$heading1 = 12;
$heading2 = 11;
$heading3= 10;
$pdf->SetLeftMargin($margin);
$pdf->SetRightMargin($margin);
//$text="Of course, the generation speed of the document is less than with PDFlib. However, the performance penalty keeps very reasonable and suits in most cases, unless your documents are particularly complex or heavy.";
$pdf->SetFont('Arial','B',$heading1);
$pdf->SetXY($margin,44);
$pdf->Cell($main,0,"LAPORAN PENYULUHAN",0,1,'C');
$pdf->SetXY($margin,$pdf->GetY()+5);
$pdf->SetFont('Arial','',$heading3);
$pdf->Cell($main,0,"Nomor : LAP-       /WPJ.13/KP.01/2020",0,1,'C');
$pdf->SetXY($margin,$pdf->GetY()+5);
$tgl_skr = new Tanggal(date('Y-m-d H:i:s'));
$pdf->Cell($main,0,'Tanggal :      '.$tgl_skr->getBln(0).' '.$tgl_skr->getThn(),0,1,'C');


//Rincian Kegiatan
$pdf->SetXY($margin,62);
$pdf->SetFont('Arial','B',$heading2);
$pdf->Cell($main,4,"I.   RINCIAN KEGIATAN",0,1,'');
$pdf->SetFont('Arial','',$heading3);
$tanggal = new Tanggal($rows[0]['waktu_penyuluhan']);
$f = ['Nama','Lokasi','Hari/Waktu','Tema','Target','Anggaran'];
$dat = [$rows[0]['nama_penyuluhan'], 
        $rows[0]['lokasi_penyuluhan'], 
        $tanggal->getHari().', '.$tanggal->getTanggal().' '.$tanggal->getJamMenit(), 
        $rows[0]['tema_penyuluhan'],
        $rows[0]['target_penyuluhan'], 
        $rows[0]['anggaran_penyuluhan']];
$pdf = identitas($pdf, $f, $dat, $margin+6, 70);

//PEserta
$pdf->SetFont('Arial','B',$heading2);
$pdf->SetXY($margin, $pdf->GetY()+10);
$pdf->Cell($main,4,"II.   PESERTA",0,1,'');

$sql2 = "SELECT npwp_peserta AS npwp, nik_peserta AS nik, nama_peserta AS nama, kehadiran FROM vw_peserta_hadir WHERE id_penyuluhan='$id'";
$result2 = $conn->query($sql2);
//$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
$rows2 = array();
while($row = $result2->fetch_assoc()) {
	array_push($rows2, $row);
}

$item = array();
foreach($rows2 as $row) {
    $ket = $row['kehadiran'] == 1 ? 'Hadir' : '';
    $r = array('nama'=> $row['nama'],'npwp'=>$row['npwp'], 'nik'=>$row['nik'], 'ket'=> $ket);
    array_push($item,$r);
}
$pdf = peserta($pdf, $item, $margin, $pdf->GetY()+5);

//Feedback
if($pdf->GetY()-40 >= 220) {
    $pdf->AddPage();
    $startH = 20;
}
$pdf->SetFont('Arial','B',$heading2);
$pdf->SetXY($margin, $pdf->GetY()+15);
$pdf->Cell($main,4,"III.   FEEDBACK",0,1,'');

$sql3 = "SELECT isi_feedback AS feedback FROM tb_feedback WHERE id_penyuluhan='$id'";
$result3 = $conn->query($sql3);
$feed = array();
if ($result3->num_rows > 0) {
    //$rows3 = $result3->fetch_all(MYSQLI_ASSOC);
	$rows3 = array();
	while($row = $result3->fetch_assoc()) {
		array_push($rows3, $row);
	}
    
    foreach($rows3 as $row){
        $f = array('feedback'=>$row['feedback']);
        array_push($feed,$f);
    }
}
$pdf->SetFont('Arial','',$heading3);
$pdf->SetXY($margin, $pdf->GetY());
$pdf = feedback($pdf,$feed,$margin,$pdf->GetY());

//Catatan
if($pdf->GetY()-40 >= 220) {
    $pdf->AddPage();
    $startH = 20;
}
$pdf->SetFont('Arial','B',$heading2);
$pdf->SetXY($margin, $pdf->GetY()+15);
$pdf->Cell($main,4,"IV.  CATATAN",0,1,'');

$sql4 = "SELECT deskripsi_laporan AS deskripsi FROM tb_laporan WHERE id_penyuluhan='$id'";
$result4 = $conn->query($sql4);
$txt_des = '';
if ($result4->num_rows == 1) {
    //$rows4 = $result4->fetch_all(MYSQLI_ASSOC);
	$rows4 = array();
	while($row = $result4->fetch_assoc()) {
		array_push($rows4, $row);
	}
    $txt_des = $rows4[0]['deskripsi'];
}

$pdf->SetFont('Arial','',$heading3);
$pdf->SetXY($margin, $pdf->GetY()+4);
$pdf->Justify($txt_des,$main,4);

$sql3 = "SELECT kode_jabatan AS kd, nama FROM vw_user_pegawai_role WHERE kode_jabatan IN (2,3,4)";
$result3 = $conn->query($sql3);
while($row = $result3->fetch_object()) {
    if ($row->kd == 2) { $ttd['ep'] = $row->nama;}
    elseif ($row->kd == 3) {$ttd['umum'] = $row->nama;}
    elseif ($row->kd == 4) { $ttd['kakap'] = $row->nama; }
}


if ($nip == 'xx') {
    $sql7 = "SELECT action_by as nip FROM tb_status_penyuluhan WHERE id_penyuluhan='$id' AND flag=7 ORDER BY time_stamp DESC LIMIT 1";
    $result7 = $conn->query($sql7);
    if ($result7->num_rows > 0) {
        //$rows7 = $result7->fetch_all(MYSQLI_ASSOC);
		$rows7 = array();
		while($row = $result7->fetch_assoc()) {
			array_push($rows7, $row);
		}
        $nip = $rows7[0]['nip'];
    }

}

$sql6 = "SELECT nama FROM vw_user_pegawai_role WHERE nip IN ('$nip')";
$result6 = $conn->query($sql6);
$petugas = 'xxx';
if ($result6->num_rows > 0) {
    //$rows6 = $result6->fetch_all(MYSQLI_ASSOC);
	$rows6 = array();
	while($row = $result6->fetch_assoc()) {
		array_push($rows6, $row);
	}
    $petugas = $rows6[0]['nama'];
}
//Tanda Tangan
$pdf->SetFont('Arial','',$heading3);
$pdf = tandatangan($pdf,$petugas,$ttd['ep'],$ttd['kakap'],$margin, $pdf->GetY()+15);
$pdf->Output();
$conn->close();
?>