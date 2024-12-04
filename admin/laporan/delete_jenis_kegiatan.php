<?php 
include "../conn/conn.php";
$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM jenis_kegiatan WHERE kegiatan='$id'");

// Simpan Aktivitas Admin
$current_user = $_SESSION['nama'];
$aktivitas = "Menghapus jenis kegiatan dengan ID: $id";
$insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
mysqli_query($conn, $insert_aktivitas);

echo "<script>window.location.href='index.php?page=add_jenis_kegiatan&status=success&status_type=3';</script>'";
exit;
?>