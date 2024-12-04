<?php
error_reporting(0);
include "../conn/conn.php";
$id_laporan = $_GET['id'];
$get_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM laporan_kegiatan WHERE id_laporan = '$id_laporan'"));
?>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Laporan</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="index.php?page=dashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Laporan</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<?php
if (isset($_POST['submit'])) {
        foreach ($_FILES['foto']['name'] as $id=>$val) {
            $fileName        = $_FILES['foto']['name'][$id];
            $tempLocation    = $_FILES['foto']['tmp_name'][$id];
            $alias_foto = date('d-m-Y').'-'.$fileName ; 
            $move = move_uploaded_file($tempLocation, '../file/'. $alias_foto);
            $result = mysqli_query($conn, "INSERT INTO foto_kegiatan (id_foto,id_laporan,foto) VALUES ('','$id_laporan','$alias_foto')");
        }
        foreach ($_FILES['pdf']['name'] as $id=>$val) {
            $fileName       = $_FILES['pdf']['name'][$id];
            $tempLocation    = $_FILES['pdf']['tmp_name'][$id];
            $alias_pdf = date('d-m-Y').'-'.$fileName ; 
            $move = move_uploaded_file($tempLocation, '../file/'. $alias_pdf);
            $result = mysqli_query($conn, "INSERT INTO pdf_kegiatan (id_pdf,id_laporan,pdf) VALUES ('','$id_laporan','$alias_pdf')");
        }
        // Simpan Aktivitas Admin
        $current_user = $_SESSION['nama'];
        $aktivitas = "Mengirimkan laporan kegiatan ID: $id_laporan";
        $insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$current_user', '$aktivitas')";
        mysqli_query($conn, $insert_aktivitas);
}
?>
<div class="row">
    <div class="col-xl-9 mx-auto">
        <div class="card border-top border-0 border-4 border-warning">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22"></i>
                        </div>
                        <h5 class="mb-0">Laporan <?= ucwords($get_data['judul_laporan']) ?></h5>
                    </div>
                    <hr />
                    <?php 
                    $data_foto = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM foto_kegiatan WHERE id_laporan = '$id_laporan'"));
                    $data_pdf = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pdf_kegiatan WHERE id_laporan = '$id_laporan'"));
                    if ($data_foto > 0 OR $data_pdf > 0) { ?>
                    <button type="button" class="btn btn-success px-2" onClick="Javascript:window.location.href = 'index.php?page=riwayat_laporan';"><i class='bx bx-check mr-1'></i> Berhasil Mengirimkan Laporan, Check Riwayat Laporan</button>
                    <?php } else {
                    ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="tgl" class="col-sm-3 col-form-label">Upload Foto Kegiatan</label>
                            <div class="col-sm-9">
                            <input id="image-uploadify" type="file" name="foto[]" accept="image/*" multiple>
                            </div>
                        </div>
                        <div class="row mb-3">
    <label for="tgl" class="col-sm-3 col-form-label">Upload Pdf Kegiatan</label>
    <div class="col-sm-9">
        <input id="image-uploadify2" type="file" name="pdf[]" accept=".pdf" multiple>
        <p id="file-size-error" style="color: red; display: none;">File terlalu besar. Maksimal ukuran file adalah 10 MB.</p>
    </div>
</div>

<script>
    document.getElementById('image-uploadify2').addEventListener('change', function() {
        var files = this.files;
        var maxSize = 10 * 1024 * 1024; // 10 MB
        
        for (var i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                document.getElementById('file-size-error').style.display = 'block';
                this.value = ''; // Clear the input field
                return;
            }
        }
        document.getElementById('file-size-error').style.display = 'none';
    });
</script>

                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                            <input type="submit" name="submit" value="Kirim Laporan" class="btn btn-primary px-5">
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>