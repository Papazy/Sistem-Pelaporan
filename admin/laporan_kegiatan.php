<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Laporan Kegiatan</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="index.php?page=dashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Laporan Kegiatan</li>
            </ol>
        </nav>
    </div>
</div>
<?php 
 include "../conn/conn.php";
?>
<!--end breadcrumb-->
<div class="">
    <div class="">
        <div class="container py-2">
            <h2 class="font-weight-light text-center text-muted py-3">Laporan Kegiatan</h2>
            <?php
            function tgl_indo($tanggal){
                $bulan = array (
                    1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
                $pecahkan = explode('-', $tanggal);
                
                return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
            }
              $query = mysqli_query($conn, "SELECT * FROM laporan_kegiatan as a JOIN staff as b ON b.id_staff = a.created_by JOIN satuan as c ON c.satuan = a.satuan JOIN jenis_kegiatan as d ON d.kegiatan = a.kegiatan  WHERE a.status='PENDING' OR a.status='DITERIMA' ORDER BY a.id_laporan DESC");
              while ($data = mysqli_fetch_array($query)) { ?>
                <div class="row">
                <div class="col-auto text-center flex-column d-none d-sm-flex">
                    <div class="row h-50">
                        <div class="col border-end">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                    </div>
                    <h5 class="m-2">
                        <span class="badge rounded-pill bg-warning">&nbsp;</span>
                    </h5>
                    <div class="row h-50">
                        <div class="col border-end">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                    </div>
                </div>
                <div class="col py-2">
                    <div class="card border-primary shadow radius-15">
                        <div class="card-body">
                            <div class="float-end text-primary"><?= tgl_indo(date('Y-m-d', strtotime($data['tgl']))).', '.$data['judul_satuan'] ?></div>
                            <h4 class="card-title text-primary">
                                <?= ucwords($data['judul_laporan']) ?> 
                                <span class="badge <?= $data['status']=="DITERIMA" ? ' bg-success' : ' bg-danger'?>" style="font-size:12px;">
                                    <?= $data['status'] ?>
                                </span>
                            </h4>
                            <p class="card-text"><?= $data['isi'] ?></p>
                            <button class="btn btn-sm btn-outline-warning" type="button" data-bs-target="#t2_details<?= $data['id_laporan']?>" data-bs-toggle="collapse">Detail Laporan ▼</button>
                            <div class="collapse border" id="t2_details<?= $data['id_laporan']?>">
                                <div class="p-2 text-monospace">
                                    <div>Lokasi : <?= ucwords($data['lokasi']) ?></div>
                                    <div>Kegiatan : <?= ucwords($data['judul_kegiatan']) ?></div>
                                    <div>Pelapor : <b><?= strtoupper($data['nama']).' - '.$data['nrp'] ?></b></div>
                                    <hr>
                                    <div>Foto : </div>
                                    <div>
                                        <?php
                                        $id_laporan = $data['id_laporan'];
                                        $query_foto = mysqli_query($conn, "SELECT * FROM foto_kegiatan WHERE id_laporan = '$id_laporan'");
                                         while ($foto = mysqli_fetch_array($query_foto)) {
                                          echo  '<img src="../file/'.$foto['foto'].'" width="150" height="120" class="border rounded cursor-pointer mr-5" alt=""> ';
                                         }
                                        ?>
                                    </div>
                                    <hr>
                                    <div>
                                    <?php
                                     $id_laporan = $data['id_laporan'];
                                     $query_pdf = mysqli_query($conn, "SELECT * FROM pdf_kegiatan WHERE id_laporan = '$id_laporan'");
                                      while ($pdf = mysqli_fetch_array($query_pdf)) {
                                        echo '<a href="../file/'.$pdf['pdf'].'" download>Unduh PDF</a>';
                                         }
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <?php 
                            if ($data['status']!="DITERIMA") { ?>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTerima<?= $data['id_laporan'] ?>">Terima Laporan</button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak<?= $data['id_laporan'] ?>">Tolak Laporan</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Terima -->
            <div class="modal fade" id="modalTerima<?= $data['id_laporan'] ?>" tabindex="-1" aria-labelledby="modalTerimaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTerimaLabel">Konfirmasi Terima Laporan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menerima laporan ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <a href="index.php?page=confirm_laporan&&id=<?= $data['id_laporan'] ?>" class="btn btn-success">Terima</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tolak -->
            <div class="modal fade" id="modalTolak<?= $data['id_laporan'] ?>" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTolakLabel">Konfirmasi Tolak Laporan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menolak laporan ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <a href="index.php?page=tolak_laporan&&id=<?= $data['id_laporan'] ?>" class="btn btn-danger">Tolak</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
</div>
