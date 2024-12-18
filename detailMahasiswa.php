<?php

require('fungsi.php');

$nim = $_POST['nim'];

$sql = "SELECT * FROM mhs WHERE nim='$nim' LIMIT 1";

$result = mysqli_query($koneksi, $sql);

$row = mysqli_fetch_assoc($result);

echo json_encode($row);

?>
