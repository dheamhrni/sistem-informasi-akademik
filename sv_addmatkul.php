<?php
// Memanggil file pustaka fungsi
require "fungsi.php";

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Memindahkan data kiriman dari form ke var biasa
$kdmatkul = $_POST["kdmatkul"];
$namamatkul = $_POST["namamatkul"];
$sks = $_POST["sks"];
$jenis = $_POST["jenis"];
$semester = $_POST["semester"];
$uploadOk = 1;

//check nim untuk mengecek data kembar
$sql = "select * from matkul where idmatkul = '$kdmatkul' ";
$qry = mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
if ( mysqli_num_rows ($qry) != 0 ){
    // echo "<div class='alert alert-danger w-25 mx-auto text-center mt-1 alert-dismissible'>
	// 		<button type='button' class='close' data-dismiss='alert'>&times;</button>
	// 		NIM Sudah Terdaftar. </div>";
    echo '<script>alert("Kode Matkul sudah terdaftar."); location.href="addMatkul.php"</script>';
    $uploadOk = 0;
}

// Check jika terjadi kesalahan
if ($uploadOk != 0) {
    // Membuat query
    $sql = "INSERT INTO matkul (idmatkul, namamatkul, sks, jns, smt) VALUES ('$kdmatkul', '$namamatkul', '$sks', '$jenis', '$semester')";
    
    // Cek koneksi dan eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        header("Location: updatematkul.php");
        exit; // Tambahkan exit setelah header
    } else {
        echo "Data gagal tersimpan: " . mysqli_error($koneksi);
    }
} 
?>
