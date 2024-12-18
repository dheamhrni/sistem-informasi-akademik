<?php
include 'fungsi.php'; // Make sure this file contains the database connection code

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $foto = $_POST['foto'];
    
    // Delete the record from the database
    $sql = "DELETE FROM mhs WHERE id='$id'";
    mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

    // Delete the photo file
    if (file_exists("foto/$foto")) {
        unlink("foto/$foto");
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
