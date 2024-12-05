<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Aktivitas Admin</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="index.php?page=dashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Aktivitas Admin</li>
            </ol>
        </nav>
    </div>
</div>
<?php 
 include "../conn/conn.php";
?>
<!--end breadcrumb-->

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Admin</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM aktivitas_admin ORDER BY waktu DESC";
                    $result = mysqli_query($conn, $query);
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Tentukan kelas warna berdasarkan aktivitas
                        $rowClass = '';
                        if (stripos($row['aktivitas'], 'login') !== false) {
                            $rowClass = 'background-color: rgba(0, 123, 255, 0.2) !important;'; 
                        } elseif (stripos($row['aktivitas'], 'ubah') !== false) {
                            $rowClass = 'background-color: rgba(255, 193, 7, 0.2) !important;'; 
                        } elseif (stripos($row['aktivitas'], 'tambah') !== false) {
                            $rowClass = 'background-color: rgba(40, 167, 69, 0.2) !important;'; 
                        }
                        
                        echo "<tr style=''>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['nama_admin'] . "</td>";
                        echo "<td>" . $row['aktivitas'] . "</td>";
                        echo "<td>" . $row['waktu'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- .activity-table-info {
	background-color: rgba(0, 123, 255, 0.2); /* Biru muda */
}
.activity-table-warning {
	background-color: rgba(255, 193, 7, 0.2); /* Kuning muda */
}
.activity-table-success {
	background-color: rgba(40, 167, 69, 0.2); /* Hijau muda */
}
 -->
