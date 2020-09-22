<?php
include "koneksi.php";

$args = explode('/',$_SERVER['REQUEST_URI']);
$len = count($args);
$kode = $args[$len-1];

$sql = "SELECT * FROM tb_link_feedback WHERE unik_string='$kode'";
$res = $conn->query($sql);
$id = '';
while($row = $res->fetch_object()) {
    $id = $row->id_penyuluhan;
}
$sql2 = "SELECT * FROM tb_materi WHERE id_materi='7'";
$res2 = $conn->query($sql2);

while($row = $res2->fetch_object()) {
    $nama = $row->file_materi;
}
header('Content-type:application/pdf');
echo $nama;

$conn->close();
?>