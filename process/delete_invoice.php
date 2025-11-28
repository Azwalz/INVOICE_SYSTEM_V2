<?php
require '../config/db.php'; // sesuaikan dengan struktur direktori kamu

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM invoice WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: ../list_invoice.php?pesan=sukses_hapus");
            exit();
        } else {
            echo "Gagal menghapus: " . $stmt->error;
        }
    } else {
        echo "Kesalahan prepare statement: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
