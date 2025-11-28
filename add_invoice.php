<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">lUVIICHEM LABORATORY</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-solid fa-money-bill"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Invoice Management
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item active">
                <a class="nav-link" href="add_invoice.php">
                    <i class="fas fa-solid fa-plus"></i>
                    <span>Tambah Invoice</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="list_invoice.php">
                    <i class="fas fa-solid fa-list"></i>
                    <span>Daftar Invoice</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
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

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest' ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="assets/img/undraw_profile_3.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tambah Invoice</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <form action="" id="invoiceForm">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-6 mb-4">
                                                    <label for="defaultFormControlInput" class="form-label">No Invoice</label>
                                                    <input type="text" name="invoice_no" class="form-control" placeholder="No Invoice..."/>
                                                </div>
                                                <div class="col-6 mb-4">
                                                    <label for="defaultFormControlInput" class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal" class="form-control" placeholder="No Invoice..."/>
                                                </div>
                                                <div class="col-6">
                                                    <label for="defaultFormControlInput" class="form-label">Nama/Perusahaan</label>
                                                    <input type="text" name="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan..."/>
                                                </div>
                                                <div class="col-6">
                                                    <label for="defaultFormControlInput" class="form-label">Alamat</label>
                                                    <input type="text" name="alamat" class="form-control" placeholder="Alamat..."/>
                                                </div>
                                            </div>
                                            <h5 class="mt-4">Barang</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered align-middle" id="itemTable">
                                                    <thead class="table-success text-center">
                                                        <tr>
                                                            <th style="width: 50px;">No</th>
                                                            <th>Jenis Barang</th>
                                                            <th style="width: 100px;">Qty</th>
                                                            <th style="width: 120px;">Satuan</th>
                                                            <th style="width: 150px;">Harga Satuan</th>
                                                            <th style="width: 150px;">Jumlah</th>
                                                            <th style="width: 80px;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="itemBody">
                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td><input type="text" name="jenis_barang[]" class="form-control" required></td>
                                                            <td><input type="number" name="qty[]" class="form-control qty" required></td>
                                                            <td><input type="text" name="satuan[]" class="form-control" required></td>
                                                            <td>
                                                                <input type="text" class="form-control harga_view" required>
                                                                <input type="hidden" name="harga_satuan[]" class="harga_raw">
                                                            </td>
                                                            <td><input type="text" name="jumlah_view[]" class="form-control jumlah" readonly></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">Hapus</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="button" class="btn btn-success mb-4" id="addRow">Tambah Barang</button>
                                            <div class="row">
                                                <div class="col-lg-4 mb-4">
                                                    <label for="defaultFormControlInput" class="form-label">SubTotal</label>
                                                    <input type="text" class="form-control" name="subtotal" id="subtotal" placeholder="0" readonly/>
                                                </div>
                                                <div class="col-lg-4 mb-4">
                                                    <label for="defaultFormControlInput" class="form-label">Diskon (%)</label>
                                                    <input type="text" class="form-control" name="diskon" id="diskon" placeholder="0"/>
                                                </div>
                                                <div class="col-lg-4 mb-4">
                                                    <label for="defaultFormControlInput" class="form-label">Total</label>
                                                    <input type="text" class="form-control" name="total" id="total" placeholder="0" readonly/>
                                                </div>
                                                <div class="col-lg-8 mb-4">
                                                    <label for="notes" class="form-label">Notes:</label>
                                                    <textarea class="form-control" name="notes" id="notes" placeholder="Masukkan catatan jika diperlukan..." rows="3"></textarea>
                                                </div>

                                                <div class="col-lg-8 mb-4">
                                                    <label for="tandatanganSelect" class="form-label">Nama Penandatangan</label>
                                                    <select class="form-control" id="tandatanganSelect" name="penandatangan" required>
                                                        <option value="">-- Pilih Penandatangan --</option>
                                                        <option value="LULU APRILIA">LULU APRILIA</option>
                                                        <option value="AGUS WIBOWO">AGUS WIBOWO</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-8">
                                                    <label for="statusSelect" class="form-label">Status</label>
                                                    <select class="form-control" id="statusSelect" name="status" required>
                                                        <option value="">-- Pilih Status --</option>
                                                        <option value="UNPAID">Unpaid</option>
                                                        <option value="PAID">Paid</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="defaultFormControlInput" class="form-label" disabled><span style="color: red;">*</span>Wajib di isi</label>
                                                    <button type="submit" class="btn btn-success w-100">Save Invoice</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> 
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; LUVIICHEM.LABORATORY 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addRowBtn = document.getElementById('addRow');
            const itemBody = document.getElementById('itemBody');

            addRowBtn.addEventListener('click', function () {
                const rowCount = itemBody.rows.length + 1;
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" name="jenis_barang[]" class="form-control" required></td>
                <td><input type="number" name="qty[]" class="form-control qty" required></td>
                <td><input type="text" name="satuan[]" class="form-control" required></td>
                <td>
                    <input type="text" class="form-control harga_view" required>
                    <input type="hidden" name="harga_satuan[]" class="harga_raw">
                </td>
                <td>
                    <input type="text" name="jumlah_view[]" class="form-control jumlah" readonly>
                    <input type="hidden" name="jumlah[]" class="jumlah_raw">
                </td>
                <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
            `;

                itemBody.appendChild(row);
            });

            itemBody.addEventListener('input', function (e) {
                if (e.target.classList.contains('qty') || e.target.classList.contains('harga_view')) {
                    calculateTotals();
                }
            });

            itemBody.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    e.target.closest('tr').remove();
                    calculateTotals();
                }
            });

            document.getElementById('diskon').addEventListener('input', calculateTotals);

            function formatNumber(num) {
                return num.toLocaleString('id-ID');
            }

            function unformatNumber(str) {
                return parseFloat(str.replace(/\./g, '') || 0);
            }

            function calculateTotals() {
                let subtotal = 0;

                document.querySelectorAll('#itemBody tr').forEach(row => {
                    const qty = parseFloat(row.querySelector('.qty')?.value || 0);

                    const harga_view = row.querySelector('.harga_view');
                    const harga_raw = row.querySelector('.harga_raw');

                    let harga = unformatNumber(harga_view.value || '0');
                    harga_raw.value = harga; // simpan nilai asli ke hidden

                    harga_view.value = harga ? formatNumber(harga) : ''; // format tampilan

                    const jumlah = qty * harga;
                    row.querySelector('.jumlah').value = formatNumber(jumlah);
                    subtotal += jumlah;
                });

                document.getElementById('subtotal').value = formatNumber(subtotal);

                const diskon = parseFloat(document.getElementById('diskon').value || 0);
                const total = subtotal - (subtotal * (diskon / 100));

                document.getElementById('total').value = formatNumber(total);
            }

            // Initial run
            calculateTotals();
        });
    </script>

    <script>
        document.getElementById('invoiceForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch('process/simpan_invoice.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                Swal.fire({
                    icon: 'success',
                    title: 'Invoice berhasil dibuat!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    form.reset();
                    window.location.href = 'list_invoice.php';
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menyimpan invoice. Silakan coba lagi.'
                });
                console.error(error);
            });
        });
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>

</body>

</html>