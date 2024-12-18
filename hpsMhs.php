<?php
//memanggil file pustaka fungsi
require "fungsi.php";

//memindahkan data kiriman dari form ke var biasa
$id=$_POST["id"];  //variabel get untuk mengambil nilai yang ada pd parameter url di simpan ke variabel id
$foto=$_POST["foto"]; 

$foto = './foto/' . $foto; // variabel ini menyimpan lokasi foto

chown($foto, 666); //mengganti permission foto menjadi 666 agar foto bisa dihapus

unlink($foto); //menghapus foto berdasarkan lokasi 

// membuat query hapus data
$sql="DELETE FROM mhs WHERE id=$id";  //query ini untuk menghapus data mahasiswa 
mysqli_query($koneksi,$sql);
?>
