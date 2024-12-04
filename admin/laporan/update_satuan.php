<?php
session_start();  // Untuk mengakses session yang menyimpan nama user yang sedang login

// Menghubungkan ke database
include "../../conn/conn.php";

// Memeriksa apakah form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $satuan_id = $_POST['satuan_id'];  // ID satuan yang akan diupdate
    $judul_satuan = mysqli_real_escape_string($conn, $_POST['judul_satuan']);  // Judul satuan baru
    $editor = mysqli_real_escape_string($conn, $_POST['editor']);  // Nama editor
    $created_by = mysqli_real_escape_string($conn, $_POST['created_by']);  // Nama pembuat (bisa disabled di form)
    
    // Mengambil waktu saat ini
    $edited_at = date("Y-m-d H:i:s");  // Format waktu saat ini

    // Query untuk update data
    $query = "UPDATE satuan SET
                judul_satuan = '$judul_satuan',
                edited_by = '$editor',
                edited_at = '$edited_at'
              WHERE satuan = '$satuan_id'";

    // Menjalankan query dan memeriksa apakah berhasil
    if (mysqli_query($conn, $query)) {

        // Simpan Aktivitas Admin
        $current_user = $_SESSION['nama'];
        $aktivitas = "Mengubah satuan dengan ID: $satuan_id";
        $insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
        mysqli_query($conn, $insert_aktivitas);

        // Redirect ke halaman yang sama atau halaman lain setelah update berhasil
        header("Location: ../index.php?page=add_satuan&status=success&status_type=2");
        exit();
    } else {
        // Jika gagal, tampilkan error
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>