<?php
include "../../conn/conn.php";

if (isset($_POST['judul_kegiatan'])) {
    $kegiatan_id = $_POST['kegiatan_id'];
    $judul_kegiatan = $_POST['judul_kegiatan'];
    $editor = $_POST['editor'];

    // Query untuk memperbarui data
    $query = "UPDATE jenis_kegiatan SET 
              judul_kegiatan = '$judul_kegiatan',
              edited_by = '$editor',
              edited_at = NOW()
              WHERE kegiatan = '$kegiatan_id'";

    if (mysqli_query($conn, $query)) {
        // Simpan Aktivitas Admin
        $current_user = $_SESSION['nama'];
        $aktivitas = "Mengubah jenis kegiatan dengan ID: $kegiatan_id";
        $insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
        mysqli_query($conn, $insert_aktivitas);

        header("Location: ../index.php?page=add_jenis_kegiatan&status=success&status_type=2");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>