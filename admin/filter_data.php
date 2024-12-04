<?php
include "../conn/conn.php";

$filterType = $_GET['filterType'] ?? '-';
$filterOption = $_GET['filterOption'] ?? 'none';

$query = "SELECT * FROM laporan_kegiatan as a 
          JOIN satuan as b ON b.satuan = a.satuan 
          JOIN jenis_kegiatan as c ON c.kegiatan = a.kegiatan 
          WHERE a.status='DITERIMA'";

if ($filterType === 'harian' && $filterOption !== 'none') {
    $query .= " AND DATE(a.tgl) = '" . date('Y-m-d', strtotime("$filterOption")) . "'";
} elseif ($filterType === 'bulanan' && $filterOption !== 'none') {
    $query .= " AND MONTH(a.tgl) = $filterOption AND YEAR(a.tgl) = " . date('Y');
} elseif ($filterType === 'tahunan' && $filterOption !== 'none') {
    $query .= " AND YEAR(a.tgl) = $filterOption";
}

$query .= " ORDER BY a.id_laporan DESC";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'pdf' => $row['pdf'], // PDF file
        'foto' => $row['foto'], // Foto
        'judul_laporan' => ucwords($row['judul_laporan']),
        'satuan' => ucfirst($row['judul_satuan']),
        'kegiatan' => ucfirst($row['judul_kegiatan']),
        'lokasi' => ucwords($row['lokasi']),
        'peserta' => ucfirst($row['isi']),
        'tanggal_laporan' => date('d-m-Y', strtotime($row['tgl']))
    ];
}

echo json_encode($data);
?>