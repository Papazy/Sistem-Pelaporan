<?php
include "../conn/conn.php";
function tgl_indo($tanggal)
{
    $bulan = array(
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

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-xl-2">
                        <!-- <a class="btn btn-primary mb-3 mb-lg-0"><i class='bx bxs-home-circle'></i>Dashboard</a> -->
                        <div class="filter-container d-flex align-items-center gap-3">
                            <div class="form-group mb-0" style="width: 120px;">
                                <label for="filterType" class="form-label">Pilih Filter:</label>
                                <select id="filterType" class="form-control" onchange="updateFilterOptions()" style="width: 120px;">
                                    <option value="-">-</option>
                                    <option value="harian">Harian</option>
                                    <option value="bulanan">Bulanan</option>
                                    <option value="tahunan">Tahunan</option>
                                </select>
                            </div>
                            <div class="form-group mb-0" style="width: 120px;">
                                <label id="filterOptionsLabel" for="filterOptions" class="form-label">Opsi:</label>
                                <select id="filterOptions" class="form-control" style="width: 120px;">
                                    <option value="none">-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-10">
                        <form class="float-lg-end">
                            <div class="row row-cols-lg-auto g-2">
                                <div class="col-12">
                                    <!-- Tanggal dalam format Indonesia -->
                                    <h3><?= tgl_indo(date('Y-m-d')) ?></h3>
                                    <!-- Jam Digital dengan Ikon -->
                                    <h4 id="jam-digital" style="margin-top: 5px; display: inline;"></h4>
                                    <span id="ikon-waktu" style="margin-left: 10px; font-size: 24px;"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateJam() {
        const now = new Date();
        const hours24 = now.getHours(); // Format 24 jam
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const ampm = hours24 >= 12 ? 'PM' : 'AM';

        // Format 24 jam tetap
        const timeString = `${hours24.toString().padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
        document.getElementById('jam-digital').textContent = timeString;

        // Mengatur ikon dan warna sesuai waktu
        const iconElement = document.getElementById('ikon-waktu');
        if (hours24 >= 6 && hours24 < 8) {
            // Matahari Terbit (06:00 - 07:59)
            iconElement.innerHTML = '🌅'; // Ikon matahari terbit
            iconElement.style.color = '#f39c12'; // Warna jingga
        } else if (hours24 >= 8 && hours24 < 12) {
            // Matahari Sejuk Pagi (08:00 - 11:59)
            iconElement.innerHTML = '🌞'; // Ikon matahari pagi
            iconElement.style.color = '#f1c40f'; // Warna kuning cerah
        } else if (hours24 >= 12 && hours24 < 17) {
            // Matahari Utuh (12:00 - 16:59)
            iconElement.innerHTML = '☀️'; // Ikon matahari utuh
            iconElement.style.color = '#e67e22'; // Warna oranye
        } else if (hours24 >= 17 && hours24 < 19) {
            // Matahari Terbenam (17:00 - 18:59)
            iconElement.innerHTML = '🌇'; // Ikon matahari terbenam
            iconElement.style.color = '#d35400'; // Warna jingga kemerahan
        } else if (hours24 >= 19 || hours24 < 0) {
            // Bulan Baru (19:00 - 23:59)
            iconElement.innerHTML = '🌙'; // Ikon bulan baru
            iconElement.style.color = '#3498db'; // Warna biru malam
        } else {
            // Bulan Tengah Malam (00:00 - 05:59)
            iconElement.innerHTML = '🌑'; // Ikon bulan tengah malam
            iconElement.style.color = '#2c3e50'; // Warna biru gelap
        }
    }

    function updateFilterOptions() {
        const filterType = document.getElementById("filterType").value;
        const filterOptions = document.getElementById("filterOptions");
        const filterOptionsLabel = document.getElementById("filterOptionsLabel");
        filterOptions.innerHTML = ""; // Clear previous options

        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth();
        const currentDate = today.getDate();

        if (filterType === "harian") {
            filterOptionsLabel.textContent = "Tanggal:";
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            for (let i = 1; i <= daysInMonth; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = `${i}`;
                if (i === currentDate) option.selected = true; // Set default to today's date
                filterOptions.appendChild(option);
            }
        } else if (filterType === "bulanan") {
            filterOptionsLabel.textContent = "Bulan:";
            const months = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            months.forEach((month, index) => {
                const option = document.createElement("option");
                option.value = index + 1;
                option.textContent = month;
                if (index === currentMonth) option.selected = true; // Set default to this month
                filterOptions.appendChild(option);
            });
        } else if (filterType === "tahunan") {
            filterOptionsLabel.textContent = "Tahun:";
            for (let i = 2015; i <= currentYear; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = `${i}`;
                if (i === currentYear) option.selected = true; // Set default to this year
                filterOptions.appendChild(option);
            }
        } else {
            filterOptionsLabel.textContent = "Opsi:"; // Default label
            const option = document.createElement("option");
            option.value = "none";
            option.textContent = "None";
            option.selected = true; // Set default to None
            filterOptions.appendChild(option);
        }
    }

    // Set default filter on page load
    window.onload = function() {
        const filterType = document.getElementById("filterType");
        filterType.value = "harian"; // Default to Harian
        updateFilterOptions();
    };


    // Update setiap detik
    setInterval(updateJam, 1000);
    updateJam();
</script>



<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
        <div class="card radius-10 bg-primary bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Anggota Terdaftar</p>
                        <h4 class="my-1 text-white">
                            <?php
                            $data_staff = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from staff"));
                            echo $data_staff['total'];
                            ?>
                        </h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-user'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-success bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Laporan Diterima</p>
                        <h4 class="my-1 text-white">
                            <?php
                            $data_laporan_diterima = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from laporan_kegiatan WHERE status='DITERIMA'"));
                            echo $data_laporan_diterima['total'];
                            ?>
                        </h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-trophy'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-danger bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Laporan Ditolak</p>
                        <h4 class="my-1 text-white">
                            <?php
                            $data_laporan_ditolak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from laporan_kegiatan WHERE status='DITOLAK'"));
                            echo $data_laporan_ditolak['total'];
                            ?>
                        </h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-x'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-warning bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Laporan Ditunda</p>
                        <h4 class="my-1 text-white">
                            <?php
                            $data_laporan_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from laporan_kegiatan WHERE status='PENDING'"));
                            echo $data_laporan_pending['total'];
                            ?>
                        </h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-time'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-info bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Laporan Masuk</p>
                        <h4 class="my-1 text-white">
                            <?php
                            $data_laporan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from laporan_kegiatan"));
                            echo $data_laporan['total'];
                            ?>
                        </h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-task'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h1>
                <center>Laporan Cepat
            </h1>
            </center>
            </script>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <center>No</center>
                                </th>
                                <th width="20%">
                                    <center>pdf</center>
                                </th>
                                <th width="50%">
                                    <center>Foto</center>
                                </th>
                                <th>
                                    <center>Judul Laporan</center>
                                </th>
                                <th width="20%">
                                    <center>Satuan</center>
                                </th>
                                <th width="20%">
                                    <center>Kegiatan</center>
                                </th>
                                <th width="20%">
                                    <center>Lokasi</center>
                                </th>
                                <th width="20%">
                                    <center>Peserta</center>
                                </th>
                                <th>
                                    <center>Tanggal Laporan<center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../conn/conn.php";
                            $no = 1;
                            $id_staff = $_SESSION['id_staff'];
                            $query = mysqli_query($conn, "SELECT * FROM laporan_kegiatan as a JOIN satuan as b ON b.satuan = a.satuan JOIN jenis_kegiatan as c ON c.kegiatan = a.kegiatan  WHERE a.status='DITERIMA' ORDER BY a.id_laporan DESC");
                            while ($data = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td>
                                        <center><?= $no++ ?></center>
                                    </td>
                                    <td>
                                        <table class="pdf">
                                            <?php
                                            $id_laporan = $data['id_laporan'];
                                            $query_pdf = mysqli_query($conn, "SELECT * FROM pdf_kegiatan WHERE id_laporan = '$id_laporan'");
                                            while ($pdf = mysqli_fetch_array($query_pdf)) {
                                                echo '<a href="../file/' . $pdf['pdf'] . '" download>Unduh PDF</a>';
                                            ?>
                                            <?php } ?>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table-foto">
                                            <?php
                                            $id_laporan = $data['id_laporan'];
                                            $query_foto = mysqli_query($conn, "SELECT * FROM foto_kegiatan WHERE id_laporan = '$id_laporan'");
                                            while ($foto = mysqli_fetch_array($query_foto)) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <img src="../file/<?= $foto['foto'] ?>" width="150" height="120" class="border rounded cursor-pointer mr-5" alt="">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                    <td>
                                        <center><b><?= ucwords($data['judul_laporan']) ?></b></center>
                                    </td>
                                    <td>
                                        <center><?= ucfirst($data['judul_satuan']) ?></center>
                                    </td>
                                    <td>
                                        <center><?= ucfirst($data['judul_kegiatan']) ?></center>
                                    </td>
                                    <td>
                                        <?= ucwords($data['lokasi']) ?>
                                    </td>
                                    <td>
                                        <center><?= ucfirst($data['isi']) ?></center>
                                    </td>
                                    <td>
                                        <center><?= tgl_indo(date('Y-m-d', strtotime($data['tgl']))) ?></center>
                                    </td>
                                </tr>
                            <?php
                            };
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>