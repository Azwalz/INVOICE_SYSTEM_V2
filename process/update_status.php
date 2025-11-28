<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $allowed_status = ['PAID', 'UNPAID'];
    if (!in_array($status, $allowed_status)) {
        echo "Status tidak valid.";
        exit;
    }

    $query = $conn->prepare("UPDATE invoice SET status = ? WHERE id = ?");
    $query->bind_param("si", $status, $id);

    if ($query->execute()) {
        echo "Status berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui status.";
    }
}
?>
