<?php
include "koneksi.php";

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $id = htmlspecialchars($_POST['id_penyuluhan']);
    $feed = htmlspecialchars($_POST['textareaFeedback']);

    $sql = "INSERT INTO tb_feedback(id_penyuluhan, isi_feedback) VALUES ('$id','$feed')";
    $res = $conn->query($sql);
    if ($res) {
        $hasil = "Berhasil menyimpan feedback";
    } else {
        $hasil = "Gagal menyimpan feedback";
    }
    die($hasil);
} else {
$args = explode('/',$_SERVER['REQUEST_URI']);
$len = count($args);
$kode = $args[$len-1];

$sql = "SELECT * FROM tb_link_feedback WHERE unik_string='$kode'";
$res = $conn->query($sql);
$id = '';
while($row = $res->fetch_object()) {
    $id = $row->id_penyuluhan;
}
$sql2 = "SELECT * FROM tb_penyuluhan WHERE id_penyuluhan='$id'";
$res2 = $conn->query($sql2);
$nama = '';
while($row = $res2->fetch_object()) {
    $nama = $row->nama_penyuluhan;
}

$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Feed Back</title>
  </head>
  <body>
    <div class="container">
    <h1>Feedback <?php echo $nama; ?></h1>
    <form id="frmFeed" method="POST">
    <input type="hidden" id="id_penyuluhan" name="id_penyuluhan" value="<?php echo $id; ?>"></input>
    <div class="form-group">
        <label for="textareaFeedback">Feedback</label>
        <textarea class="form-control" id="textareaFeedback" name="textareaFeedback" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
<?php
}
?>