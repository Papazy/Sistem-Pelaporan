<?php
session_start();  // Untuk mengakses session yang menyimpan nama user yang sedang login

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

    $query_sebelum = "SELECT * FROM jenis_kegiatan WHERE kegiatan='$kegiatan_id'";
    $result_sebelum = mysqli_query($conn, $query_sebelum);
    $data_jenis_kegiatan_sebelum = mysqli_fetch_assoc($result_sebelum);
    $judul_kegiatan_sebelum = $data_jenis_kegiatan_sebelum['judul_kegiatan'];
    if (mysqli_query($conn, $query)) {

        // Simpan Aktivitas Admin
        $current_user = $_SESSION['nama'];
        $aktivitas = "ubah jenis kegiatan: `$judul_kegiatan_sebelum` menjadi `$judul_kegiatan`";
        $insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
        mysqli_query($conn, $insert_aktivitas);

        header("Location: ../index.php?page=add_jenis_kegiatan&status=success&status_type=2");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>