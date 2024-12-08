<?php
session_start();
if (!isset($_SESSION['id_staff'])) {
	header("Location: ../login.php");
	exit();
}
?>

<?php
date_default_timezone_set('Asia/Jakarta');
?>
<!doctype html>
<html lang="en" class="color-sidebar sidebarcolor2 color-header headercolor2">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="../assets/images/bidtik.png" type="image/png" />
	<!--plugins-->
	<link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="../assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<link href="../assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<link href="../assets/plugins/fancy-file-uploader/fancy_fileupload.css" rel="stylesheet" />
	<link href="../assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="../assets/css/pace.min.css" rel="stylesheet" />
	<script src="../assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="../assets/css/app.css" rel="stylesheet">
	<link href="../assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="../assets/css/dark-theme.css" />
	<link rel="stylesheet" href="../assets/css/semi-dark.css" />
	<link rel="stylesheet" href="../assets/css/header-colors.css" />
	<script type="text/javascript" src="chartjs/Chart.js"></script>
	<title>E-Laporan Kegiatan</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true" style="z-index: 10002;">
			<div class="sidebar-header">
				<div>
					<img src="../assets/images/bidtik.png" width="50px" height="50px" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">TIK Polri</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="index.php?page=dashboard">
						<div class="parent-icon"><i class='bx bx-home'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li>
					<a href="index.php?page=profile">
						<div class="parent-icon"><i class='bx bx-user-circle'></i>
						</div>
						<div class="menu-title">Profile</div>
					</a>
				</li>
				<li>
					<a href="index.php?page=laporan_kegiatan">
						<div class="parent-icon"><i class='bx bx-time'></i>
						</div>
						<div class="menu-title">Laporan Kegiatan</div>
					</a>
				</li>
				<li>
					<a href="index.php?page=aktivitas_admin">
						<div class="parent-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
  <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
</svg>
						</div>
						<div class="menu-title">Aktivitas Admin</div>
					</a>
				</li>
				<li>
				<li class="menu-label">Menu Laporan</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-chalkboard'></i>
						</div>
						<div class="menu-title">Laporan</div>
					</a>
					<ul>
						<li>
							<a href="index.php?page=add_laporan"><i class="bx bx-calendar-star"></i>Buat Laporan</a>
						</li>
						<li>
							<a href="index.php?page=riwayat_laporan"><i class="bx bx-history"></i>Riwayat Laporan</a>
						</li>
						<li>
							<a href="index.php?page=add_satuan"><i class="bx bx-book-add"></i>Tambah Satuan</a>
						</li>
						<li>
							<a href="index.php?page=add_jenis_kegiatan"><i class="bx bx-book-add"></i>Tambah Jenis Kegiatan</a>
						</li>
						<!-- <li> <a href="index.php?page=list_anggota"><i class="bx bx-user-check"></i>List Anggota</a>
						</li> -->
					</ul>
				</li>
				<li class="menu-label">Menu Anggota</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-user'></i>
						</div>
						<div class="menu-title">Anggota</div>
					</a>
					<ul>
						<li> <a href="index.php?page=add_anggota"><i class="bx bx-user-plus"></i>Tambah Anggota</a>
						</li>
						<li> <a href="index.php?page=list_anggota"><i class="bx bx-user-check"></i>List Anggota</a>
						</li>
					</ul>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center" style="z-index: 1000;">
				<nav class="navbar navbar-expand" >
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="search-bar flex-grow-1">
						<div class="position-relative search-bar-box">
							<input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
							<span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
						</div>
					</div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#"> <i class='bx bx-search'></i>
								</a>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" data-bs-toggle="dropdown" aria-expanded="false">
									<!-- <i class='bx bx-bell'></i> -->
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<div class="header-notifications-list">
										<!-- <a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-primary text-primary"><i class="bx bx-group"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
												ago</span></h6>
													<p class="msg-info">5 new user registered</p>
												</div>
											</div>
										</a> -->
									</div>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<!-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>
									<i class='bx bx-comment'></i>
								</a> -->
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Messages</p>
											<p class="msg-header-clear ms-auto">Marks all as read</p>
										</div>
									</a>
									<div class="header-message-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-1.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Daisy Anderson <span class="msg-time float-end">5 sec
															ago</span></h6>
													<p class="msg-info">The standard chunk of lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-2.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Althea Cabardo <span class="msg-time float-end">14
															sec ago</span></h6>
													<p class="msg-info">Many desktop publishing packages</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-3.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Oscar Garner <span class="msg-time float-end">8 min
															ago</span></h6>
													<p class="msg-info">Various versions have evolved over</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-4.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Katherine Pechon <span class="msg-time float-end">15
															min ago</span></h6>
													<p class="msg-info">Making this the first true generator</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-5.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Amelia Doe <span class="msg-time float-end">22 min
															ago</span></h6>
													<p class="msg-info">Duis aute irure dolor in reprehenderit</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-6.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Cristina Jhons <span class="msg-time float-end">2 hrs
															ago</span></h6>
													<p class="msg-info">The passage is attributed to an unknown</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-7.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">James Caviness <span class="msg-time float-end">4 hrs
															ago</span></h6>
													<p class="msg-info">The point of using Lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-8.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Peter Costanzo <span class="msg-time float-end">6 hrs
															ago</span></h6>
													<p class="msg-info">It was popularised in the 1960s</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-9.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">David Buckley <span class="msg-time float-end">2 hrs
															ago</span></h6>
													<p class="msg-info">Various versions have evolved over</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-10.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Thomas Wheeler <span class="msg-time float-end">2 days
															ago</span></h6>
													<p class="msg-info">If you are going to use a passage</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="../assets/images/avatars/avatar-11.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Johnny Seitz <span class="msg-time float-end">5 days
															ago</span></h6>
													<p class="msg-info">All the Lorem Ipsum generators</p>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Messages</div>
									</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="../assets/images/team.png" class="user-img" alt="user avatar">
							<div class="user-info ps-3">
								<p class="user-name mb-0"><?= ucwords($_SESSION['nama']); ?></p>
								<p class="designattion mb-0">Administrator</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="index.php?page=profile"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="logout.php"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
<!-- Modal Success -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" id="modalHeader">
        <h5 class="modal-title" id="successModalLabel" style="color:white">Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center py-2">
          <span id="modalMessage"></span>
          <div class="icon ms-2" id="modalIcon">
            <!-- SVG icon will be inserted here dynamically -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
  window.onload = function() {
  // Ambil parameter status dan status_type dari URL
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  const statusType = urlParams.get('status_type');

  // Tentukan elemen header, pesan, dan ikon
  const modalHeader = document.getElementById('modalHeader');
  const modalIcon = document.getElementById('modalIcon');
  const modalMessage = document.getElementById('modalMessage');

  if (status === 'success') {
    let message = '';
    let headerColor = '';
    let iconColor = '';

    // Tentukan pesan, warna header, dan warna ikon berdasarkan status_type
    switch (statusType) {
      case '1': // Create
        message = 'Data berhasil dibuat!';
        headerColor = 'bg-success'; // Hijau
        iconColor = 'green';
        break;
      case '2': // Update
        message = 'Data berhasil diperbarui!';
        headerColor = 'bg-warning'; // Kuning
        iconColor = 'orange';
        break;
      case '3': // Delete
        message = 'Data berhasil dihapus!';
        headerColor = 'bg-danger'; // merah
        iconColor = 'red';
        break;
				case '4': // Terima
					message = 'Laporan Diterima!';
					headerColor = 'bg-success'; // Hijau
					iconColor = 'green';
					break;
				case '5': // Tolak
					message = 'Laporan Ditolak!';
					headerColor = 'bg-danger'; // merah
					iconColor = 'red';
					break;
      default:
        message = 'Operasi berhasil!';
        headerColor = 'bg-primary'; // Default biru
        iconColor = 'blue';
    }

    // Set warna header
    modalHeader.className = `modal-header ${headerColor}`;

    // Set pesan modal
    modalMessage.innerText = message;

    // Set ikon SVG
    modalIcon.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="${iconColor}" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </svg>
    `;

    // Tampilkan modal success
    const myModal = new bootstrap.Modal(document.getElementById('successModal'), {
      keyboard: false
    });
    myModal.show();
  }
};
</script>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<?php
				if (isset($_GET['page'])) {
					$page = $_GET['page'];

					switch ($page) {
						case 'dashboard':
							include "home.php";
							break;
						case 'profile':
							include "profile.php";
							break;
						case 'laporan_kegiatan':
							include "laporan_kegiatan.php";
							break;
						case 'aktivitas_admin':
							include "aktivitas_admin.php";
							break;
						case 'confirm_laporan':
							include "laporan/confirm_laporan.php";
							break;
						case 'tolak_laporan':
							include "laporan/tolak_laporan.php";
							break;
							
							//anggota
						case 'add_anggota':
							include "staff/add_anggota.php";
							break;
						case 'list_anggota':
							include "staff/list_anggota.php";
							break;
						case 'edit_anggota':
							include "staff/edit_anggota.php";
							break;
						case 'delete_anggota':
							include "staff/delete_anggota.php";
							break;
							// laporan
						case 'add_laporan':
							include "laporan/add_laporan.php";
							break;
						case 'upload_laporan':
							include "laporan/upload_laporan.php";
							break;
						case 'edit_laporan':
							include "laporan/edit_laporan.php";
							break;
						case 'delete_laporan':
							include "laporan/delete_laporan.php";
							break;
						case 'riwayat_laporan':
							include "laporan/riwayat_laporan.php";
							break;
						case 'add_satuan':
							include "laporan/add_satuan.php";
							break;
						case 'delete_satuan':
							include "laporan/delete_satuan.php";
							break;
						case 'add_jenis_kegiatan':
							include "laporan/add_jenis_kegiatan.php";
							break;
						case 'delete_jenis_kegiatan':
							include "laporan/delete_jenis_kegiatan.php";
							break;
						default:
							echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
							break;
					}
				} else {
					include "home.php";
				}

				?>
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2024. TIK Polda Aceh
			</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="../assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="../assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script src='https://cdn.tiny.cloud/1/vdqx2klew412up5bcbpwivg1th6nrh3murc6maz8bukgos4v/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
	<script src="../assets/plugins/fancy-file-uploader/jquery.ui.widget.js"></script>
	<script src="../assets/plugins/fancy-file-uploader/jquery.fileupload.js"></script>
	<script src="../assets/plugins/fancy-file-uploader/jquery.iframe-transport.js"></script>
	<script src="../assets/plugins/fancy-file-uploader/jquery.fancy-fileupload.js"></script>
	<script src="../assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#show_hide_password a").on('click', function(event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});

			window.setTimeout(function() {
				$(".alert").fadeTo(1000, 0).slideUp(1000, function() {
					$(this).remove();
				});
			}, 2000);

			$(document).ready(function() {
				$('#example').DataTable();
			});

			$(document).ready(function() {
				var table = $('#example2').DataTable({
					lengthChange: false,
					buttons: [ 'copy', 	'excel', {
              extend: 'print',
              exportOptions: {
                stripHtml: false,
							}
            }]
				});

				table.buttons().container()
					.appendTo('#example2_wrapper .col-md-6:eq(0)');
			});

			tinymce.init({
				selector: '#mytextarea'
			});

			$('#fancy-file-upload').FancyFileUpload({
				params: {
					action: 'fileuploader'
				},
				maxfilesize: 1000000
			});

			$(document).ready(function() {
				$('#image-uploadify').imageuploadify();
			})
			$(document).ready(function() {
				$('#image-uploadify2').imageuploadify();
			})
		});
	</script>
	<script>
  $(document).ready(function () {
    var table = $('#example3').DataTable({
      "createdRow": function (row, data, dataIndex) {
        // Cek nilai pada kolom aktivitas (indeks ke-2, karena array dimulai dari 0)
        const aktivitas = data[2].toLowerCase(); // Kolom aktivitas
        if (aktivitas.includes("ubah")) {
          $(row).css('background-color', 'rgba(255, 193, 7, 0.2)'); // Kuning muda
        } else if (aktivitas.includes("tambah")) {
          $(row).css('background-color', 'rgba(40, 167, 69, 0.2)'); // Hijau muda
        } else if (aktivitas.includes("hapus")) {
          $(row).css('background-color', 'rgba(220, 53, 69, 0.2)'); // Merah muda
        } else if (aktivitas.includes("logout")) {
          $(row).css('background-color', 'rgba(0, 123, 255, 0.2)'); // Biru muda
        }
      }
    });
  });
</script>
	<!--app JS-->
	<script src="../assets/js/app.js"></script>
</body>

</html>