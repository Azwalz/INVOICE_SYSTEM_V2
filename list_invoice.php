<?php
session_start();
require_once 'config/db.php';

// Ambil filter dan search jika ada
$status_filter = $_GET['status'] ?? 'semua';
$search = $_GET['search'] ?? '';
$tanggal = $_GET['tanggal'] ?? ''; // PERBAIKAN: Ganti 'hari_tanggal' dengan 'tanggal'

$query = "SELECT * FROM invoice WHERE 1";

// Filter status
if ($status_filter === 'PAID') {
    $query .= " AND status = 'PAID'";
} elseif ($status_filter === 'UNPAID') {
    $query .= " AND status = 'UNPAID'";
}

// Filter pencarian
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $query .= " AND (nama_perusahaan LIKE '%$search%' OR no_invoice LIKE '%$search%')";
}

// Filter tanggal tunggal
if (!empty($tanggal)) {
    $tanggal = $conn->real_escape_string($tanggal);
    // Asumsi: Kolom 'hari_tanggal' di DB berformat YYYY-MM-DD (tipe DATE)
    $query .= " AND hari_tanggal = '$tanggal'";
}

$query .= " ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Daftar Invoice</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/main.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">lUVIICHEM LABORATORY</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-solid fa-money-bill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Invoice Management
            </div>
            <li class="nav-item">
                <a class="nav-link" href="add_invoice.php">
                    <i class="fas fa-solid fa-plus"></i>
                    <span>Tambah Invoice</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="list_invoice.php">
                    <i class="fas fa-solid fa-list"></i>
                    <span>Daftar Invoice</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest' ?>
                                </span>
                                <img class="img-profile rounded-circle" src="assets/img/undraw_profile_3.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Daftar Invoice</h1>
                    </div>

                    <form method="GET" id="filterForm">
                        <div class="row g-2 mb-3">
                            <div class="col-lg-3">
                                <select class="form-control" id="statusSelect" name="status">
                                    <option value="semua" <?= $status_filter === 'semua' ? 'selected' : '' ?>>--Pilih Status--</option>
                                    <option value="PAID" <?= $status_filter === 'PAID' ? 'selected' : '' ?>>PAID</option>
                                    <option value="UNPAID" <?= $status_filter === 'UNPAID' ? 'selected' : '' ?>>UNPAID</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="tanggal" class="form-control" id="tanggalInput" value="<?= htmlspecialchars($tanggal) ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama / invoice..." value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-md-2">
                                <a class="btn btn-outline-secondary w-100" href="list_invoice.php">Reset</a>
                            </div>
                        </div>
                    </form>

                    <?php if ($result && $result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>No Invoice</th>
                                    <th>Nama/Perusahaan</th>
                                    <th>Tanggal Invoice</th>
                                    <th>Dibuat Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Penandatangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['no_invoice']) ?></td>
                                    <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                                    <td><?= !empty($row['hari_tanggal']) ? date('d/m/Y', strtotime($row['hari_tanggal'])) : 'N/A' ?></td>
                                    <?php
                                        $bulanIndo = ['01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'];
                                        $created = new DateTime($row['created_at']);
                                        $day = $created->format('j');
                                        $month = $bulanIndo[$created->format('m')];
                                        $year = $created->format('Y');
                                        $time = $created->format('H:i');
                                    ?>
                                    <td><?= "$day $month $year, $time" ?></td>
                                    <td><?= number_format($row['total'], 0, ',', '.') ?></td>
                                    <td>
                                        <select class="form-select form-select-sm status-dropdown <?= strtolower($row['status']) ?>" data-id="<?= $row['id'] ?>">
                                            <option value="UNPAID" <?= $row['status'] == 'UNPAID' ? 'selected' : '' ?>>UNPAID</option>
                                            <option value="PAID" <?= $row['status'] == 'PAID' ? 'selected' : '' ?>>PAID</option>
                                        </select>
                                    </td>
                                    <td><?= htmlspecialchars($row['penandatangan'] ?? '') ?></td>
                                    <td>
                                        <div class="d-inline-flex gap-0">
                                            <a href="process/show_invoice.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm rounded-end-0">Show</a>
                                            <a href="process/delete_invoice.php?id=<?= $row['id'] ?>" 
                                                onclick="return confirm('Yakin ingin hapus invoice ini?')" 
                                                class="btn btn-danger btn-sm rounded-start-0" 
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info">Tidak ada invoice ditemukan.</div>
                    <?php endif; ?>
                </div>
                </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; LUVIICHEM.LABORATORY 2025</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="process/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
    <script src="assets/vendor/chart.js/Chart.min.js"></script>
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>

    <script>
        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function () {
                const invoiceId = this.dataset.id;
                const newStatus = this.value;

                fetch('process/update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${invoiceId}&status=${newStatus}`
                })
                .then(response => response.text())
                .then(result => {
                    console.log(result);
                    // Refresh halaman untuk menampilkan status yang baru
                    // window.location.reload(); 
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
    
    <script>
        document.getElementById('statusSelect').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('tanggalInput').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
        
        // Opsional: Anda bisa menambahkan auto-submit untuk pencarian saat tombol "enter" ditekan
        document.querySelector('input[name="search"]').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Mencegah form dikirim ulang
                document.getElementById('filterForm').submit();
            }
        });
    </script>

</body>
</html>
