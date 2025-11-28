<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ... (lanjutan kode Anda)

session_start();
require_once '../config/db.php';

// Ambil input dari form
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Cek input tidak kosong
if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username dan password wajib diisi!";
    header("Location: ../login.php");
    exit;
}

// Query cek username & password
$stmt = $conn->prepare("SELECT username FROM admin WHERE username = ? AND password = SHA2(?, 256)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Simpan username ke session
    $_SESSION['username'] = $row['username'];

    // Arahkan ke dashboard
    header("Location: ../index.php");
    exit;
} else {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: ../login.php");
    exit;
}
