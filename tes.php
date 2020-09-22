<?php

require('plugin/justification.php');

function identitas($pdf, $field, $data, $margin, $startH) {
    $idx = 0;
    $height = 6;
    foreach($data as $d) {
        $pdf->SetXY($margin,$startH);
        $pdf->Write(4,$field[$idx]);
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
    $pdf->SetXY($margin+108,$startH);
    $pdf->Cell(38,$height,'NIK Peserta',1,0,'C');
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
        $pdf->SetXY($margin+108,$startH);
        $pdf->Cell(38,$height,$d['nik'],1);
        $idx+=1;
        $startH += $height;
    }
    return $pdf;
}

function tandatangan($pdf, $kakap, $margin, $startH) {
    if($pdf->GetY()-40 == 220) {
        $pdf->AddPage();
        $startH = 20;
    }
    $height = 6;
    //Jabatan
    $pdf->SetXY($margin,$startH);
    $pdf->Cell(100,$height,"");
    $pdf->SetXY($margin+100,$startH);
    $pdf->Cell(60,$height,'Kepala Kantor,');

    //nama pejabat
    $startH +=30;
    $pdf->SetXY($margin,$startH);
    $pdf->Cell(100,$height,"");
    $pdf->SetXY($margin+100,$startH);
    $pdf->Cell(60,$height,$kakap);
    return $pdf;
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
$height = 5;
$pdf->SetLeftMargin($margin);
$pdf->SetRightMargin($margin);

$pdf->SetFont('Arial','',$heading3);
$pdf->SetXY($margin,42);
$pdf->Cell($main,$height,"28 Agustus 2020",0,0,'R');
$pdf->Ln();
$pdf->Cell(20,$height,"Nomor");
$pdf->Cell(5,$height,":");
$pdf->Cell(5,$height,"UND-/WPJ.13/KP.01/2020");
$pdf->Ln();
$pdf->Cell(20,$height,"Sifat");
$pdf->Cell(5,$height,":");
$pdf->Cell(5,$height,"Segera");
$pdf->Ln();
$pdf->Cell(20,$height,"Hal");
$pdf->Cell(5,$height,":");
$pdf->Cell(5,$height,"Undangan");

$pdf->SetXY($margin, $pdf->GetY()+15);
$pdf->Cell(20,$height,"Yth. Eko Yudhi Prastowo");
$pdf->Ln();
$pdf->Cell(20,$height,"NPWP 49.549.983.2-646.000");

$pdf->SetXY($margin, $pdf->GetY()+15);
$pdf->Justify("I have written a script to benchmark the several methods of outputting data in PHP: via single quotes, double quotes, heredoc, and printf. The script constructs a paragraph of text with each method. It performs this construction 10,000 times, then records how long it took. In total, it prints 160,000 times and records 16 timings. Here are the raw results.",$main,$height);

$f = ['Nama', 'Hari/Tanggal', 'Waktu', 'Lokasi'];
$d = ['COba 1','Kamis, 31 Agustus 2020', '09:00','Online'];
$pdf=identitas($pdf,$f,$d,$margin+20,$pdf->GetY()+$height);

$pdf->SetXY($margin, $pdf->GetY()+$height+5);
$pdf->Justify("I have written a script to benchmark the several methods of outputting data in PHP: via single quotes, double quotes, heredoc, and printf. The script constructs a paragraph of text with each method.",$main,$height);

//Tanda Tangan
$pdf = tandatangan($pdf,"Dia",$margin, $pdf->GetY()+15);
$pdf->Output();

?>