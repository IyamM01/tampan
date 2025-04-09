<?php
$host = "localhost:3309"; // Tambahkan port 3309
$user = "root";   // Ganti jika pakai user lain
$pass = "12345";       // Password MySQL (biarkan kosong jika default)
$db   = "db_sampah";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
