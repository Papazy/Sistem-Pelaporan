<?php 
include "../conn/conn.php";
$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM satuan WHERE satuan='$id'");
echo "<script>window.location.href='index.php?page=add_satuan&status=success&status_type=3';</script>'";
exit;
?>