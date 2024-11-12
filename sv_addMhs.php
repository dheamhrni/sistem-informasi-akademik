<?php
// Memanggil file pustaka fungsi
require "fungsi.php";

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Memindahkan data kiriman dari form ke var biasa
$nim = $_POST["nim"];
$nama = $_POST["nama"];
$email = $_POST["email"];
$uploadOk = 1;

// Set lokasi dan nama file foto
$folderupload = "foto/";
$filefoto = basename($_FILES['foto']['name']);
$unique = uniqid();
$fileupload = $folderupload . $unique . "-" . $filefoto; // Menambahkan ID unik

// Ambil jenis file
$jenisfilefoto = strtolower(pathinfo($fileupload, PATHINFO_EXTENSION)); // jpg, png, gif


//check nim untuk mengecek data kembar
$sql = "select * from mhs where nim = '$nim' ";
$qry = mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
if ( mysqli_num_rows ($qry) != 0 ){
    // echo "<div class='alert alert-danger w-25 mx-auto text-center mt-1 alert-dismissible'>
	// 		<button type='button' class='close' data-dismiss='alert'>&times;</button>
	// 		NIM Sudah Terdaftar. </div>";
    echo '<script>alert("Nim sudah terdaftar."); location.href="addMhs.php"</script>';
    $uploadOk = 0;
}
// Check jika file foto sudah ada
if (file_exists($fileupload)) {
    echo "Maaf, file foto sudah ada<br>";
    $uploadOk = 0;
}

// Check ukuran file
if ($_FILES["foto"]["size"] > 1000000) {
    echo "Maaf, ukuran file foto harus kurang dari 1 MB<br>";
    $uploadOk = 0;
}

// Hanya file tertentu yang dapat digunakan
if (!in_array($jenisfilefoto, ['jpg', 'jpeg', 'png', 'gif'])) {
    echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan<br>";
    $uploadOk = 0;
}

// Check jika terjadi kesalahan
if ($uploadOk != 0) {
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $fileupload)) {
        echo "File berhasil diupload.<br>"; // Debug
        // Membuat query
        $sql = "INSERT INTO mhs (nim, nama, email, foto) VALUES ('$nim', '$nama', '$email', '$unique-$filefoto')";
        
        // Cek koneksi dan eksekusi query
        if (mysqli_query($koneksi, $sql)) {
            header("Location: updateMhs.php");
            exit; // Tambahkan exit setelah header
        } else {
            echo "Data gagal tersimpan: " . mysqli_error($koneksi);
        }
    } else {
        echo "Error saat mengupload file: " . $_FILES["foto"]["error"] . "<br>";
    }
}
?>
