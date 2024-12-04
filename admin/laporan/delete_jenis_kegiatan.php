<?php 
include "../conn/conn.php";
$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM jenis_kegiatan WHERE kegiatan='$id'");
echo "<script>window.location.href='index.php?page=add_jenis_kegiatan';</script>'";
exit;
?>