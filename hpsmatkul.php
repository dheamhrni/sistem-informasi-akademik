<?php
//memanggil file pustaka fungsi
require "fungsi.php";

//memindahkan data kiriman dari form ke var biasa
$id=$_GET["kode"];  //variabel get untuk mengambil nilai yang ada pd parameter url di simpan ke variabel id
// $foto=$_POST["foto"]; 

// membuat query hapus data
$sql="DELETE FROM matkul WHERE idmatkul='$id'";  //query ini untuk menghapus data mahasiswa 
mysqli_query($koneksi,$sql);
?>
