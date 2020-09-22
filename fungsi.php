<?php

class Fungsi {
    public static function statusFlag($kode) {
        $hasil = "";
        if ($kode == 1) { $hasil = '<span class="badge badge-pill badge-light">Perekaman</span>';}
        elseif($kode == 2) {$hasil = '<span class="badge badge-pill badge-secondary">Persetujuan Kasi EP</span>';}
        elseif($kode == 3) {$hasil = '<span class="badge badge-pill badge-secondary">Persetujuan Kasubbag Umum</span>';}
        elseif($kode == 4) {$hasil = '<span class="badge badge-pill badge-primary">Persetujuan Kepala Kantor</span>';}
        elseif($kode == 5) {$hasil = '<span class="badge badge-pill badge-dark">Disetujui</span>';}
        elseif($kode == 6) {$hasil = '<span class="badge badge-pill badge-danger">Pembuatan Laporan</span>';}
        elseif($kode == 7) {$hasil = '<span class="badge badge-pill badge-primary">Persetujuan Laporan</span>';}
        elseif($kode == 8) {$hasil = '<span class="badge badge-pill badge-success">Selesai</span>';}
        return $hasil;
    }

    public static function ketRole($role) {
        $hasil = "";
        if ($role == 1) { $hasil = "Kepala Seksi EP"; }
        elseif ($role == 2) { $hasil = "Kepala Subbagian Umum"; }
        elseif ($role == 3) { $hasil = "Kepala KPP";}
        elseif ($role == 4) { $hasil = "Petugas Penyuluhan"; }
        elseif ($role == 5) { $hasil = "tanpa role";} 
        elseif ($role == 8) { $hasil = "Super Administrator";}
        elseif ($role == 9) { $hasil = "Admin Penyuluhan";}
        return $hasil;
    }

    public function maskingNama($thing) {
        $r = explode(' ',$thing);
        $res = "";
        foreach($r as $x) {
            $ln = strlen($x);
            if ($ln <= 3) {
                $res = $res.' '.$x;
            } else {
                $w = substr($x,0,3);
                $m = "";
                for($i=0;$i<$ln-3;$i++) {
                    $m = $m.'*';
                }
                $res = $res.' '.$w.$m;
            }
        }
        return $res;
    }
}

class Tanggal {
    private $timestamp;

    function __construct($datetime) {
        $this->timestamp = strtotime($datetime);
    }

    function getTanggal() {
        $bln = date('n',$this->timestamp);
        switch ($bln) {
            case 1:
                $bulan = 'Januari';
                break;
            case 2:
                $bulan = 'Februari';
                break;
            case 3:
                $bulan = 'Maret';
                break;
            case 4:
                $bulan = 'April';
                break;
            case 5:
                $bulan = 'Mei';
                break;
            case 6:
                $bulan = 'Juni';
                break;
            case 7:
                $bulan = 'Juli';
                break;
            case 8:
                $bulan = 'Agustus';
                break;
            case 9:
                $bulan = 'September';
                break;
            case 10:
                $bulan = 'Oktober';
                break;
            case 11:
                $bulan = 'November';
                break;
            case 12:
                $bulan = 'Desember';
                break;
            default:
                $bulan = 'XXXXX';
                break;
        }

        $tgl = date('j', $this->timestamp);
        $thn = date('Y', $this->timestamp);
        return $tgl.' '.$bulan.' '.$thn;
    }

    function getPure() {
        return date("Y-m-d H:i:s", $this->timestamp);
    }

    function getHari() {
        $day = date('w', $this->timestamp);
        switch ($day) {
            case 0;
                $hari = "Minggu";
                break;
            case 1;
                $hari = "Senin";
                break;
            case 2;
                $hari = "Selasa";
                break;
            case 3;
                $hari = "Rabu";
                break;
            case 4;
                $hari = "Kamis";
                break;
            case 5;
                $hari = "Jumat";
                break;
            case 6;
                $hari = "Sabtu";
                break;
            default:
                $hari = "XXX";
                break;
        }
        return $hari;
    }

    function getJamMenit() {
        $jam = date('H', $this->timestamp);
        $menit = date('i',$this->timestamp);
        return $jam.':'.$menit;
    }

    function getBln($arg) {
        $bln = date('n',$this->timestamp);
        switch ($bln) {
            case 1:
                $bulan = 'Januari';
                break;
            case 2:
                $bulan = 'Februari';
                break;
            case 3:
                $bulan = 'Maret';
                break;
            case 4:
                $bulan = 'April';
                break;
            case 5:
                $bulan = 'Mei';
                break;
            case 6:
                $bulan = 'Juni';
                break;
            case 7:
                $bulan = 'Juli';
                break;
            case 8:
                $bulan = 'Agustus';
                break;
            case 9:
                $bulan = 'September';
                break;
            case 10:
                $bulan = 'Oktober';
                break;
            case 11:
                $bulan = 'November';
                break;
            case 12:
                $bulan = 'Desember';
                break;
            default:
                $bulan = 'XXXXX';
                break;
        }
        if ($arg==0) {
            $res = $bulan;
        } elseif ($arg == 1) {
            $res = substr($bulan,0,3);
        } else {
            $res = $bulan;
        }
        return $res;
    }

    function getTgl() {
        return date('j', $this->timestamp);
    }

    function getThn() {
        return date('Y', $this->timestamp);
    }
}
?>