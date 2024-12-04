<?php 
include "../conn/conn.php";
$id_laporan = $_GET['id'];

// mendapatkan data laporan

$query = "SELECT * FROM laporan_kegiatan WHERE id_laporan='$id_laporan'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$judul_laporan = $row['judul_laporan'];

mysqli_query($conn,"UPDATE laporan_kegiatan SET status='DITERIMA' WHERE id_laporan='$id_laporan'");

// Simpan Aktivitas Admin
$current_user = $_SESSION['nama'];
$aktivitas = "Menerima laporan kegiatan dengan Judul: $judul_laporan";
$insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
mysqli_query($conn, $insert_aktivitas);

echo "<script>window.location.href='index.php?page=laporan_kegiatan&status=success&status_type=2';</script>'";
exit;
?>