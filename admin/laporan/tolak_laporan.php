<?php 
include "../conn/conn.php";
$id_laporan = $_GET['id'];
mysqli_query($conn,"UPDATE laporan_kegiatan SET status='DITOLAK' WHERE id_laporan='$id_laporan'");

// Simpan Aktivitas Admin
$current_user = $_SESSION['nama'];
$aktivitas = "Menolak laporan kegiatan dengan ID: $id_laporan";
$insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
mysqli_query($conn, $insert_aktivitas);

echo "<script>window.location.href='index.php?page=laporan_kegiatan&status=success&status_type=2';</script>'";
exit;
?>