<?php 
include "../conn/conn.php";
$id = $_GET['id'];
$query = "SELECT * FROM satuan WHERE satuan='$id'";
$result = mysqli_query($conn, $query);
$data_satuan = mysqli_fetch_assoc($result);
$judul_satuan = $data_satuan['judul_satuan'];

mysqli_query($conn,"DELETE FROM satuan WHERE satuan='$id'");

// Simpan Aktivitas Admin
$current_user = $_SESSION['nama'];
$aktivitas = "hapus satuan: `$judul_satuan`";
$insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
mysqli_query($conn, $insert_aktivitas);

echo "<script>window.location.href='index.php?page=add_satuan&status=success&status_type=3';</script>'";
exit;
?>