<?php

// include "koneksi.php";
// include "fungsi.php";


// $sql = "SELECT * FROM tb_penyuluhan WHERE id_penyuluhan='3'";
// $result = $conn->query($sql);
// $rows = $result->fetch_all(MYSQLI_ASSOC);

// //header("Content-type:application/json");
// $datetime = $rows[0]['waktu_penyuluhan'];

// $tanggal = new Tanggal($datetime);

// echo $tanggal->getTanggal();
// echo "<br>";
// echo $tanggal->getHari();

// $conn->close();

$args = explode('/',$_SERVER['REQUEST_URI']);
if($args[0] == 'x.php') array_shift($args);
echo $args[2];
if (CRYPT_STD_DES == 1) {
    echo 'Standard DES: ' . crypt('rasmuslerdorf', 'rl') . "\n";
}
?>