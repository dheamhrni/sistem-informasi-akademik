<?php
include 'fungsi.php'; // Assuming you have a connection file

$halAktif = isset($_POST['hal']) ? $_POST['hal'] : 1;
$limit = 10;
$awalData = ($halAktif - 1) * $limit;

$cari = isset($_POST['cari']) ? $_POST['cari'] : '';

$sql = "SELECT * FROM matkul WHERE idmatkul LIKE '%$cari%' OR namamatkul LIKE '%$cari%' LIMIT $awalData, $limit";
$hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

$sqlTotal = "SELECT COUNT(*) as total FROM matkul WHERE idmatkul LIKE '%$cari%' OR namamatkul LIKE '%$cari%'";
$totalResult = mysqli_query($koneksi, $sqlTotal);
$total = mysqli_fetch_assoc($totalResult)['total'];
$jmlHal = ceil($total / $limit);

$data = [];
while ($row = mysqli_fetch_assoc($hasil)) {
    $data[] = $row;
}

$response = [
    'data' => $data,
    'halAktif' => $halAktif,
    'jmlHal' => $jmlHal
];

echo json_encode($response);
?>
