<?php 
include "../conn/conn.php";
$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM laporan_kegiatan WHERE id_laporan='$id'");
mysqli_query($conn,"DELETE FROM foto_kegiatan WHERE id_laporan='$id'");
mysqli_query($conn,"DELETE FROM pdf_kegiatan WHERE id_laporan='$id'");

// Simpan Aktivitas Admin
$current_user = $_SESSION['nama'];
$aktivitas = "Menghapus laporan kegiatan dengan ID: $id";
$insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
mysqli_query($conn, $insert_aktivitas);

echo "<script>window.location.href='index.php?page=riwayat_laporan&status=success&status_type=3';</script>'";
exit;
?>