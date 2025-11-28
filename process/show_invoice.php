<?php
session_start();
require_once '../config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invoice tidak ditemukan.");
}

$id = intval($_GET['id']);
if ($id <= 0) {
    die("ID invoice tidak valid.");
}

// Ambil data invoice
$stmt = $conn->prepare("SELECT * FROM invoice WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$invoice = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$invoice) {
    die("Invoice tidak ditemukan.");
}

// Ambil item invoice
$stmt2 = $conn->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$items = $stmt2->get_result();
$stmt2->close();

$conn->close();

function tanggal_indonesia($tanggal) {
    $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $date = new DateTime($tanggal);
    return $hari[$date->format('w')] . ', ' . $date->format('d') . ' ' . $bulan[$date->format('n')-1] . ' ' . $date->format('Y');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - <?= htmlspecialchars($invoice['no_invoice']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Arial', sans-serif; background: #fff; }
        .invoice-header { border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 30px; }
        .invoice-title { font-size: 1.8rem; font-weight: bold; color: #D5BFE4; letter-spacing: 2px; }
        .table th { background-color: #D5BFE4; color: #fff; }
        .table td, .table th { vertical-align: middle; }
        .table-custom-footer th { width: 60%; }
        .status-badge { padding: 6px 14px; border-radius: 6px; font-weight: bold; font-size: 1rem; }
        .status-paid { background-color: #1496e0ff; color: #fff; }
        .status-unpaid { background-color: #e74c3c; color: #fff; }
        .footer-section { border-top: 2px solid #ddd; padding-top: 20px; margin-top: 40px; }
        .signature { text-align: right; }
        .signature-img { height: 60px; display: block; margin: 0 0 5px auto; }
        .signature-name { border-bottom: 1px solid #000; display: inline-block; padding-bottom: 5px; font-weight: bold; margin: 0 }
        .signature-position { margin-bottom: 0; display: block; margin-top: 2px; font-size: 0.875rem; }
    </style>
</head>
<body>

<div class="container py-4">

    <!-- Tombol Cetak -->
    <div class="mb-3 text-end d-print-none">
        <a href="../list_invoice.php" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button class="btn btn-primary btn-sm" onclick="window.print()"><i class="bi bi-printer me-1"></i> Cetak</button>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center invoice-header">
        <div>
            <img src="../assets/img/LogoLuviichem.png" alt="Logo" style="height: 120px;">
        </div>
        <div class="text-end">
            <h5 class="mb-0 fw-bold">LUVIICHEM.LABORATORY</h5>
            <small>Jl. Letnan Arsyad Gg. H. Iman Rt 004/001 No. 18, Kel. Kayuringin Jaya</small><br>
            <small>Kota Bekasi, Jawa Barat</small><br>
            <small>Telp: 0877-6806-5455 | Email: luviichem.laboratory@gmail.com</small>
        </div>
    </div>

    <!-- Title -->
    <div class="text-center mb-4">
        <div class="invoice-title">INVOICE</div>
    </div>

    <!-- Info Perusahaan & Invoice -->
    <div class="row mb-4">
        <div class="col-6">
            <p class="mb-1"><strong>Kepada Yth.</strong></p>
            <p class="fw-bold"><?= htmlspecialchars($invoice['nama_perusahaan']) ?></p>
            <p class="mb-0"><?= nl2br(htmlspecialchars($invoice['alamat'])) ?></p>
        </div>
        <div class="col-6">
            <table class="table table-borderless table-sm">
                <tr>
                    <th>No Invoice</th>
                    <td><?= htmlspecialchars($invoice['no_invoice']) ?></td>
                </tr>
                <tr>
                    <th>Hari, Tanggal Invoice</th>
                    <td><?= tanggal_indonesia($invoice['hari_tanggal']) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if (strtoupper($invoice['status']) === 'PAID'): ?>
                            <span class="status-badge status-paid">PAID</span>
                        <?php else: ?>
                            <span class="status-badge status-unpaid">UNPAID</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tabel Barang -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th>Jenis Barang</th>
                <th class="text-center" style="width: 80px;">Qty</th>
                <th class="text-center" style="width: 80px;">Satuan</th>
                <th class="text-end" style="width: 120px;">Harga Satuan</th>
                <th class="text-end" style="width: 140px;">Jumlah Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $items->fetch_assoc()): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['jenis_barang']) ?></td>
                    <td class="text-center"><?= $row['qty'] ?></td>
                    <td class="text-center"><?= htmlspecialchars($row['satuan']) ?></td>
                    <td class="text-end"><?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($row['jumlah_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Total -->
    <div class="row justify-content-end">
        <div class="col-md-5">
            <table class="table table-borderless">
                <tr>
                    <th>SUB TOTAL</th>
                    <td class="text-end">Rp <?= number_format($invoice['subtotal'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <th>DISKON</th>
                    <td class="text-end"><?= $invoice['diskon'] ?>%</td>
                </tr>
                <tr class="fw-bold fs-5">
                    <th>TOTAL</th>
                    <td class="text-end">Rp <?= number_format($invoice['total'], 0, ',', '.') ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-section mt-1">
        <div class="row">

            <!-- Pembayaran -->
            <div class="col-6">
                <p class="fw-bold mb-1">PEMBAYARAN:</p>
                <p class="mb-0">BCA: 740-253-0360</p>
                <p class="mb-3">A.n Lulu Aprilia</p>
            </div>

            <!-- Notes -->
                <div class="col-12 mb-4">
                    <?php if (!empty($invoice['notes'])): ?>
                        <p class="fw-bold mb-1">NOTES:</p>
                        <div class="p-2 border rounded" style="min-height: 80px; word-wrap: break-word;">
                            <?= nl2br(htmlspecialchars($invoice['notes'])) ?>
                        </div>
                    <?php endif; ?>
                </div>

            <!-- Tanda tangan -->
            <div class="col-12 d-flex justify-content-end">
                <?php if ($invoice['penandatangan'] == 'LULU APRILIA'): ?>
                <div class="col-6 text-end signature">
                    <img class="signature-img" src="../assets/img/ttd_luluAprilia.png" alt="ttd" style="height: 100px;">
                    <p class="signature-name">LULU APRILIA</p>
                    <small class="signature-position">(Direktur)</small>
                </div>
                <?php else: ?>
                <div class="col-6 text-end signature">
                    <img class="signature-img" src="../assets/img/ttd_agus.png" alt="ttd" style="height: 60px;">
                    <p class="signature-name">AGUS WIBOWO</p>
                    <small class="signature-position">(Komersial)</small>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

</body>
</html>
