<?php
include 'db_config.php';

$sql = "SELECT status FROM tempat_sampah WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode(["status" => $row['status']]);

$conn->close();
?>
