<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Laporan</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="index.php?page=dashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Jenis Kegiatan</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<?php
if (isset($_POST['submit'])) {
    include "../conn/conn.php";
    $judul = $_POST['judul'];
    $created_by = $_SESSION['nama'];
    $created_at = date('d-m-Y H:i:s');
    $query = mysqli_query($conn, "SELECT * FROM jenis_kegiatan WHERE judul_kegiatan = '$judul'");
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="font-35 text-white"><i class="bx bxs-window-alt"></i>
            </div>
            <div class="ms-3">
                <h6 class="mb-0 text-white">Oopps !!! Judul Telah di Tersedia</h6>
            </div>
        </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    } else {
        mysqli_query($conn, "INSERT INTO jenis_kegiatan(kegiatan,judul_kegiatan,created_by,created_at)
        VALUES ('','$judul','$created_by','$created_at')");
        // Simpan Aktivitas Admin
        $aktivitas = "Menambahkan jenis kegiatan: $judul";
        $insert_aktivitas = "INSERT INTO aktivitas_admin (nama_admin, aktivitas) VALUES ('$created_by', '$aktivitas')";
        mysqli_query($conn, $insert_aktivitas);
        echo '
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="font-35 text-white"><i class="bx bxs-window-alt"></i>
            </div>
            <div class="ms-3">
                <h6 class="mb-0 text-white">Berhasil Menambahkan Jenis Kegiatan Baru</h6>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        ';
    }
}
?>
<div class="card border-top border-0 border-4 border-warning">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div><i class="bx bxs-window-alt me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Jenis Kegiatan</h5>
        </div>
        <hr>
        <form class="row g-3" method="post" action="" enctype="multipart/form-data">
            <div class="col-md-9">
                <input type="text" name="judul" class="form-control" id="inputFirstName">
            </div>
            <div class="col-md-3">
                <button type="submit" name="submit" class="btn btn-primary px-5">Simpan</button>
            </div>
        </form>
    </div>
</div>
<h6 class="mb-0 text-uppercase">Kegiatan</h6>
<hr />
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th width="5%">
                <center>No</center>
            </th>
            <th>
                <center>Kegiatan</center>
            </th>
            <th width="20%">
                <center>Di Buat </center>
            </th>
            <th width="10%">Tanggal Buat</th>
            <th width="20%">
                <center>Di Edit </center>
            </th>
            <th width="10%">Tanggal Edit</th>
            <th width="5%">
                <center>Action</center>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../conn/conn.php";
        $no = 1;
        $query = mysqli_query($conn, "SELECT * FROM jenis_kegiatan");
        while ($data = mysqli_fetch_array($query)) { ?>
            <tr>
                <td>
                    <center><?= $no++ ?></center>
                </td>
                <td><center><i><?= $data['judul_kegiatan'] ?></i></center></td>
                <td><?= ucwords($data['created_by']) ?></td>
                <td>
                    <center><?= $data['created_at']?></center>
                </td>
                <td><?= ucwords($data['edited_by']) ?></td>
                <td>
                    <center><?= $data['edited_at']?></center>
                </td>
                <td class="text-center">
                    <!-- Tombol Edit dengan ikon -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $data['kegiatan'] ?>">
                        <i class="bx bxs-edit"></i> Edit
                    </button>
                    <!-- Tombol Hapus dengan ikon -->
                    <a href="index.php?page=delete_jenis_kegiatan&id=<?= $data['kegiatan'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('Delete This?')">
                        <i class="bx bxs-trash"></i> Hapus
                    </a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $data['kegiatan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Kegiatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Edit -->
                            <form action="laporan/update_jenis_kegiatan.php" method="POST">
                                <div class="form-group">
                                    <label for="judul_kegiatan">Judul Kegiatan</label>
                                    <input type="text" class="form-control" name="judul_kegiatan" value="<?= $data['judul_kegiatan'] ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="created_by">Created By</label>
                                    <input type="text" class="form-control" name="created_by" value="<?= $data['created_by'] ?>" disabled>
                                </div>
                                <input type="hidden" name="kegiatan_id" value="<?= $data['kegiatan'] ?>">
                                <input type="hidden" name="editor" value="<?= ucwords($_SESSION['nama']); ?>">
                                <button type="submit" class="btn btn-primary mt-2">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        };
        ?>
    </tbody>
</table>
        </div>
    </div>
</div>