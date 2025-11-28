<?php
session_start();
require_once '../config/db.php';

// Fungsi ubah format 000.000 ke angka asli
function toNumber($str) {
    return floatval(str_replace('.', '', $str));
}

// Ambil data utama
$invoice_no       = $_POST['invoice_no'];
$nama_perusahaan  = $_POST['nama_perusahaan'];
$alamat           = $_POST['alamat'];
$tanggal          = $_POST['tanggal'];
$status           = $_POST['status'];
$penandatangan    = $_POST['penandatangan'];
$notes            = $_POST['notes'];

$subtotal = toNumber($_POST['subtotal']);
$diskon   = floatval($_POST['diskon']);
$total    = toNumber($_POST['total']);

// Simpan ke tabel invoice
$stmt = $conn->prepare("INSERT INTO invoice (no_invoice, nama_perusahaan, alamat, hari_tanggal, subtotal, diskon, total, status, penandatangan, notes) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssddssss", $invoice_no, $nama_perusahaan, $alamat, $tanggal, $subtotal, $diskon, $total, $status, $penandatangan, $notes);

if (!$stmt->execute()) {
    echo "Gagal menyimpan invoice utama: " . $stmt->error;
    exit;
}

$invoice_id = $conn->insert_id;

// Ambil data item barang
$jenis_barang   = $_POST['jenis_barang'];
$qty            = $_POST['qty'];
$satuan         = $_POST['satuan'];
$harga_satuan   = $_POST['harga_satuan']; // input hidden berisi angka asli

for ($i = 0; $i < count($jenis_barang); $i++) {
    $jenis      = $jenis_barang[$i];
    $jumlah     = intval($qty[$i]);
    $sat        = $satuan[$i];
    $harga      = floatval($harga_satuan[$i]);
    $total_item = $jumlah * $harga;

    $stmt_item = $conn->prepare("INSERT INTO invoice_items (invoice_id, jenis_barang, qty, satuan, harga_satuan, jumlah_harga) 
                                 VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_item->bind_param("isissd", $invoice_id, $jenis, $jumlah, $sat, $harga, $total_item);

    if (!$stmt_item->execute()) {
        echo "Gagal menyimpan item: " . $stmt_item->error;
        exit;
    }
}

// Sukses
echo "OK";
exit;
?>
