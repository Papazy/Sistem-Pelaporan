<?php 
include "../conn/conn.php";
$id = $_GET['id'];

$query = "SELECT * FROM jenis_kegiatan WHERE kegiatan='$id'";
$result = mysqli_query($conn, $query);
$data_jenis_kegiatan = mysqli_fetch_assoc($result);
$judul_kegiatan = $data_jenis_kegiatan['judul_kegiatan'];

mysqli_query($conn,"DELETE FROM jenis_kegiatan WHERE kegiatan='$id'");

// Simpan Aktivitas Admin
$current_user = $_SESSION['nama'];
$aktivitas = "hapus jenis kegiatan: `$judul_kegiatan`";
$insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
mysqli_query($conn, $insert_aktivitas);

echo "<script>window.location.href='index.php?page=add_jenis_kegiatan&status=success&status_type=3';</script>'";
exit;
?>