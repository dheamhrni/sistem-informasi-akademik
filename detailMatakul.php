<?php

require('fungsi.php');

$kode = $_POST['kode'];

$sql = "SELECT * FROM matkul WHERE idmatkul='$kode' LIMIT 1";

$result = mysqli_query($koneksi, $sql);

$row = mysqli_fetch_assoc($result);

echo json_encode($row);

?>
