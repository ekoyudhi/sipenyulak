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
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        die('id not set');
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
        $idx+=1;
        $startH += $height;
    }
    return $pdf;
}

function tandatangan($pdf, $ep, $umum, $kakap, $margin, $startH) {
    if($pdf->GetY()-40 == 220) {
        $pdf->AddPage();
        $startH = 20;
    }
    $height = 6;
    //Jabatan
    $pdf->SetXY($margin,$startH);
    $pdf->Cell(60,$height,"Kepala Kantor,");
    $pdf->SetXY($margin+60,$startH);
    $pdf->Cell(60,$height,'Kepala Subbagian Umum,');
    $pdf->SetXY($margin+120,$startH);
    $pdf->Cell(38,$height,'Kepala Seksi EP,');

    //nama pejabat
    $startH +=30;
    $pdf->SetXY($margin,$startH);
    $pdf->Cell(60,$height,$kakap);
    $pdf->SetXY($margin+60,$startH);
    $pdf->Cell(60,$height,$umum);
    $pdf->SetXY($margin+120,$startH);
    $pdf->Cell(38,$height,$ep);
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

$pdf->SetFont('Arial','B',$heading1);
$pdf->SetXY($margin,42);
$pdf->Cell($main,4,"RENCANA PENYULUHAN",0,1,'C');

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
$pdf->SetFont('Arial','B',$heading2);
$pdf->SetXY($margin, $pdf->GetY()+10);
$pdf->Cell($main,4,"II.   CALON PESERTA",0,1,'');

$sql2 = "SELECT npwp_peserta AS npwp, nik_peserta AS nik, nama_peserta AS nama FROM tb_peserta WHERE id_penyuluhan='$id'";
$result2 = $conn->query($sql2);
//$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
$rows2 = array();
while($row = $result2->fetch_assoc()) {
	array_push($rows2, $row);
}

$item = array();
foreach($rows2 as $row) {
    $r = array('nama'=> $row['nama'],'npwp'=>$row['npwp'], 'nik'=>$row['nik']);
    array_push($item,$r);
}
$pdf = peserta($pdf, $item, $margin, $pdf->GetY()+5);

$sql3 = "SELECT kode_jabatan AS kd, nama FROM vw_user_pegawai_role WHERE kode_jabatan IN (2,3,4)";
$result3 = $conn->query($sql3);
while($row = $result3->fetch_object()) {
    if ($row->kd == 2) { $ttd['ep'] = $row->nama;}
    elseif ($row->kd == 3) {$ttd['umum'] = $row->nama;}
    elseif ($row->kd == 4) { $ttd['kakap'] = $row->nama; }
}
//Tanda Tangan
$pdf = tandatangan($pdf,$ttd['ep'],$ttd['umum'],$ttd['kakap'],$margin, $pdf->GetY()+15);
$pdf->Output();

$conn->close();
?>