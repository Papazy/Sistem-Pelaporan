<?php
include "../conn/conn.php";

function tgl_indo($tanggal)
{
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

$filterType = isset($_GET['filterType']) ? $_GET['filterType'] : '-';
$filterValue = isset($_GET['filterValue']) ? $_GET['filterValue'] : '-';

$id_staff = $_SESSION['id_staff'] ?? null; 
$filterCondition = "";
$filterConditionWithoutAND = "";

// Menambahkan kondisi filter berdasarkan jenis filter
if ($filterType === 'harian' && $filterValue !== '-') {
    $filterCondition = "AND DATE(a.created_at) = '$filterValue'";
    $filterConditionWithoutAND = "WHERE DATE(a.created_at) = '$filterValue'";
} elseif ($filterType === 'bulanan' && $filterValue !== '-') {
    $filterCondition = "AND DATE_FORMAT(a.created_at, '%Y-%m') = '$filterValue'";
    $filterConditionWithoutAND = "WHERE DATE_FORMAT(a.created_at, '%Y-%m') = '$filterValue'";
} elseif ($filterType === 'tahunan' && $filterValue !== '-') {
    $filterCondition = "AND YEAR(a.created_at) = '$filterValue'";
    $filterConditionWithoutAND = "WHERE YEAR(a.created_at) = '$filterValue'";
}

// Query utama untuk laporan diterima
$laporanQuery = "
    SELECT 
        a.*, 
        b.judul_satuan, 
        c.judul_kegiatan 
    FROM laporan_kegiatan a
    JOIN satuan b ON b.satuan = a.satuan
    JOIN jenis_kegiatan c ON c.kegiatan = a.kegiatan
    WHERE a.status='DITERIMA' $filterCondition
    ORDER BY a.id_laporan DESC
";

$laporanData = mysqli_query($conn, $laporanQuery);
$laporanResult = [];
$fotoData = [];
$pdfData = [];
$idLaporan = [];

// Menyimpan data laporan
if ($laporanData) {
    while ($data = mysqli_fetch_assoc($laporanData)) {
        $idLaporan[] = $data['id_laporan'];
        $laporanResult[] = $data;
    }
}

// Jika ada laporan, fetch foto dan PDF terkait
if (!empty($idLaporan)) {
    $idLaporanList = implode(",", array_map('intval', $idLaporan)); // Sanitasi ID

    $fotoQuery = "SELECT * FROM foto_kegiatan WHERE id_laporan IN ($idLaporanList)";
    $pdfQuery = "SELECT * FROM pdf_kegiatan WHERE id_laporan IN ($idLaporanList)";

    $fotoResult = mysqli_query($conn, $fotoQuery);
    $pdfResult = mysqli_query($conn, $pdfQuery);

    if ($fotoResult) {
        while ($foto = mysqli_fetch_assoc($fotoResult)) {
            $fotoData[$foto['id_laporan']][] = $foto['foto'];
        }
    }

    if ($pdfResult) {
        while ($pdf = mysqli_fetch_assoc($pdfResult)) {
            $pdfData[$pdf['id_laporan']][] = $pdf['pdf'];
        }
    }
}

// Query untuk statistik
$statistikQuery = "
    SELECT 
        (SELECT COUNT(*) FROM staff) AS total_staff,
        (SELECT COUNT(*) FROM laporan_kegiatan a WHERE status = 'DITERIMA' $filterCondition) AS total_laporan_diterima,
        (SELECT COUNT(*) FROM laporan_kegiatan a WHERE status = 'DITOLAK' $filterCondition) AS total_laporan_ditolak,
        (SELECT COUNT(*) FROM laporan_kegiatan a WHERE status = 'PENDING' $filterCondition) AS total_laporan_pending,
        (SELECT COUNT(*) FROM laporan_kegiatan a $filterConditionWithoutAND) AS total_laporan
";

$result = mysqli_query($conn, $statistikQuery);
$data = mysqli_fetch_assoc($result);

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-xl-2">
                        <div class="filter-container d-flex flex-wrap gap-3">
                            <div class="form-group mb-0">
                                <label for="filterType" class="form-label">Pilih Filter:</label>
                                <select id="filterType" class="form-control" onchange="updateFilterOptions()">
                                    <option value="-">All</option>
                                    <option value="harian">Harian</option>
                                    <option value="bulanan">Bulanan</option>
                                    <option value="tahunan">Tahunan</option>
                                </select>
                            </div>
                            <div class="form-group mb-0" style="width: 120px;">
                                <label id="filterOptionsLabel" for="filterOptions" class="form-label">Opsi:</label>
                                <select id="filterOptions" class="form-control" style="width: 120px;">
                                    <option value="all">-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ms-2">
                            <button class="btn btn-primary" onclick="filterTable()">Filter</button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-8 ms-auto">
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



    // Update setiap detik
    setInterval(updateJam, 1000);
    updateJam();
</script>
<script>
    function updateFilterOptions() {
    const filterType = document.getElementById("filterType").value;
    const filterOptions = document.getElementById("filterOptions");
    const filterOptionsLabel = document.getElementById("filterOptionsLabel");
    filterOptions.innerHTML = ""; // Clear previous options

    const today = new Date();
    const currentYear = today.getFullYear();
    const currentMonth = today.getMonth(); // 0-based index (0 = January)
    const currentDate = today.getDate();

    if (filterType === "harian") {
        filterOptionsLabel.textContent = "Tanggal:";
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        for (let i = 1; i <= daysInMonth; i++) {
            const option = document.createElement("option");
            option.value = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            option.textContent = `${i} `;
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
            option.value = `${currentYear}-${String(index + 1).padStart(2, '0')}`;
            option.textContent = `${month} `;
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
        option.value = "-";
        option.textContent = "-";
        option.selected = true; // Set default to None
        filterOptions.appendChild(option);
    }
}

function getMonthName(monthIndex) {
    const months = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    return months[monthIndex];
}

function updateFilterOptionsOnLoad(filterType, valueFilter) {
   
    const filterOptions = document.getElementById("filterOptions");
    const filterOptionsLabel = document.getElementById("filterOptionsLabel");
    console.log('filter Options value', filterOptions)
    filterOptions.innerHTML = ""; // Clear previous options

    const today = new Date();
    const currentYear = today.getFullYear();
    const currentMonth = today.getMonth(); // 0-based index (0 = January)
    const currentDate = today.getDate();

    if (filterType === "harian") {
        filterOptionsLabel.textContent = "Tanggal:";
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        for (let i = 1; i <= daysInMonth; i++) {
            const option = document.createElement("option");
            option.value = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            option.textContent = `${i} `;
            if (i === valueFilter) option.selected = true; // Set default to today's date
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
            option.value = `${currentYear}-${String(index + 1).padStart(2, '0')}`;
            option.textContent = `${month} `;
            console.log("month", month, " filter", valueFilter)
            if (month === valueFilter) option.selected = true; // Set default to this month
            filterOptions.appendChild(option);
        });
    } else if (filterType === "tahunan") {
        filterOptionsLabel.textContent = "Tahun:";
        for (let i = 2015; i <= currentYear; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = `${i}`;
            if (i == valueFilter) option.selected = true; // Set default to this year
            filterOptions.appendChild(option);
        }
    } else {
        filterOptionsLabel.textContent = "Opsi:"; // Default label
        const option = document.createElement("option");
        option.value = "-";
        option.textContent = "-";
        option.selected = true; // Set default to all
        filterOptions.appendChild(option);
    }
}

function filterTable() {
    const filterType = document.getElementById('filterType').value;
    const filterValue = document.getElementById('filterOptions').value;

    if (filterType !== '-' && filterValue !== 'all') {
        window.location.href = `index.php?filterType=${filterType}&filterValue=${filterValue}`;
    } else {
        window.location.href = `index.php`;
    }
}

    // Set default filter on page load
    window.onload = function() {
    const filterType = getParameterByName('filterType');
    const filterValue = getParameterByName('filterValue');

    // Set filterType pada dropdown
    if (filterType) {
        document.getElementById('filterType').value = filterType;
    }

    // Set filterValue pada dropdown atau input terkait
    let valueFilter
    if (filterValue) {
        if (filterType === 'harian') {
            // Filter harian, ambil hanya tanggal
            const date = new Date(filterValue);
            const day = date.getDate();  // Ambil tanggal saja
            valueFilter = day;  // Set nilai filterOptions ke tanggal
            
        } else if (filterType === 'bulanan') {
            // Filter bulanan, ambil bulan dan tahun
            const month = filterValue.split('-')[1];  // Ambil bulan (misal 12 untuk Desember)
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const monthName = monthNames[parseInt(month) - 1]; // Mengonversi bulan ke nama bulan
            valueFilter = monthName;  // Set nilai filterOptions ke nama bulan
            console.log("month", monthName)
        } else if (filterType === 'tahunan') {
            // Filter tahunan, ambil tahun saja
            valueFilter = filterValue;  // Set nilai filterOptions ke tahun
        }
    }

    // Update filter options
    console.log("filterType", filterType, "filterValue", valueFilter)
    updateFilterOptionsOnLoad(filterType, valueFilter);
    
};

// Fungsi untuk mengambil parameter dari URL query string
function getParameterByName(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.has(name) ? urlParams.get(name) : null;
}

</script>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
        <div class="card radius-10 bg-primary bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Anggota Terdaftar</p>
                        <h4 class="my-1 text-white"><?= $data['total_staff']; ?></h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-user'></i></div>
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
                        <h4 class="my-1 text-white"><?= $data['total_laporan_diterima']; ?></h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-trophy'></i></div>
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
                        <h4 class="my-1 text-white"><?= $data['total_laporan_ditolak']; ?></h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-x'></i></div>
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
                        <h4 class="my-1 text-white"><?= $data['total_laporan_pending']; ?></h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-time'></i></div>
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
                        <h4 class="my-1 text-white"><?= $data['total_laporan']; ?></h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-task'></i></div>
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
                            $no = 1;
                            foreach ($laporanResult as $data) {
                                $id_laporan = $data['id_laporan'];
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    
                                    <td>
                                        <?php if (!empty($fotoData[$id_laporan])) {
                                            foreach ($fotoData[$id_laporan] as $foto) { ?>
                                                <img src="../file/<?= $foto ?>" width="150" height="120" class="border rounded" alt=""><br>
                                        <?php }
                                        } ?>
                                    </td>
                                    <td><b><?= ucwords($data['judul_laporan']) ?></b></td>
                                    <td><?= ucfirst($data['judul_satuan']) ?></td>
                                    <td><?= ucfirst($data['judul_kegiatan']) ?></td>
                                    <td><?= ucwords($data['lokasi']) ?></td>
                                    <td><?= ucfirst($data['isi']) ?></td>
                                    <td><?= tgl_indo(date('Y-m-d', strtotime($data['tgl']))) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>