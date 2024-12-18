<?php
include 'fungsi.php'; // Make sure this file contains the database connection code

// memindahkan data kiriman dari form ke var biasa
$id = $_POST["id"];
$nama = $_POST["nama"];
$email = $_POST["email"];

// Update the record in the database
$sql = "UPDATE mhs SET nama='$nama', email='$email' WHERE id=$id";

if (mysqli_query($koneksi, $sql)) {
    // echo "Data berhasil diperbarui";
    echo $id . $nama . $email;
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
