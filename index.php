<?php
include 'db_config.php';

// Ambil status & lokasi tempat sampah dari database
$sql = "SELECT status, latitude, longitude FROM tempat_sampah WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$status = $row['status'];
$latitude = $row['latitude'];
$longitude = $row['longitude'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Sampah Pintar</title>

    <!-- Tambahkan Leaflet.js (Library Peta) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: linear-gradient(to right, #56CCF2, #2F80ED);
            color: white;
            opacity: 0;
            animation: fadeIn 1.5s forwards;
            margin: 0;
            padding-top: 20px;
        }

        #map {
            width: 60%;
            height: 700px;
            margin: 40px auto 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
            z-index: 1000;
            color: black;
            animation: scaleUp 0.3s ease-in-out;
        }

        #popup button {
            margin-top: 10px;
            padding: 10px 20px;
            background: #ff3b3b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        #popup button:hover {
            background: #d32f2f;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleUp {
            from { transform: translate(-50%, -50%) scale(0.8); }
            to { transform: translate(-50%, -50%) scale(1); }
        }

        .status-card {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
        }

        .card {
            background: white;
            color: black;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            min-width: 200px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Lokasi Tempat Sampah</h1>
    <div class="status-card">
        <div class="card">Sampah Kosong: <span id="statusKosong">0</span></div>
        <div class="card">Sampah Penuh: <span id="statusPenuh">0</span></div>
    </div>
    
    <div id="map"></div>

    <div id="popup">
        <h3>Status Tempat Sampah</h3>
        <p id="statusText"></p>
        <button onclick="closePopup()">OK</button>
    </div>

    <script>
        var map = L.map('map').setView([-7.7956, 110.3695], 18); // Lokasi awal (Yogyakarta)
        
        // Tambahkan layer peta dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var statusSampah = "kosong"; // Default status

        // Tambahkan marker (ikon tempat sampah)
        var iconKosong = L.icon({ iconUrl: 'green-bin.png', iconSize: [30, 30] });
        var iconPenuh = L.icon({ iconUrl: 'penuh.jpg', iconSize: [30, 30] });

        var marker = L.marker([-7.7956, 110.3695], { icon: iconKosong }).addTo(map);

        marker.on("click", function() {
            document.getElementById("statusText").innerText = "Status: " + statusSampah.toUpperCase();
            document.getElementById("popup").style.display = "block";
        });

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        // Menampilkan jumlah tong sampah yang kosong dan penuh
        function updateStatusSummary() {
            fetch("get_status.php")
                .then(response => response.json())
                .then(data => {
                    statusSampah = data.status;
                    marker.setIcon(statusSampah === "penuh" ? iconPenuh : iconKosong);
                    document.getElementById("statusKosong").innerText = data.kosong;
                    document.getElementById("statusPenuh").innerText = data.penuh;
                });
        }

        // Auto-refresh status setiap 5 detik
        setInterval(updateStatusSummary, 5000);
    </script>

</body>
</html>