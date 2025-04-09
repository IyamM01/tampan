<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];  // Menerima data dari ESP8266

    // Update status tempat sampah di database
    $sql = "UPDATE tempat_sampah SET status = '$status' WHERE id = 1";

    if ($conn->query($sql) === TRUE) {
        echo "Status berhasil diperbarui";
    } else {
        echo "Gagal memperbarui status: " . $conn->error;
    }
}

$conn->close();
?>
