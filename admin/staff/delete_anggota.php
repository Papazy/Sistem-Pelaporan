<?php 
include "../conn/conn.php";
$id = $_GET['id'];
$query = "SELECT * FROM staff WHERE id_staff='$id'";
$result = mysqli_query($conn, $query);
$staff = mysqli_fetch_assoc($result);
$staff_name = $staff['nama'];
$staff_nrp = $staff['nrp'];

mysqli_query($conn,"DELETE FROM staff WHERE id_staff='$id'");

// Simpan Aktivitas Admin
$current_user = $_SESSION['nama'];
$aktivitas = "hapus anggota: `$staff_name` dengan NRP: `$staff_nrp`";
$insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
mysqli_query($conn, $insert_aktivitas);

echo "<script>window.location.href='index.php?page=list_anggota';</script>'";
exit;
?>