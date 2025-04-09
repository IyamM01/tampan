#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "Lilik label";  // Ganti dengan SSID WiFi kamu
const char* password = "liliklabel82";  // Ganti dengan password WiFi kamu
const char* serverUrl = "http://192.168.0.103/tempatsampah/update_status.php"; // Ubah dengan IP Laragon kamu

#define TRIG_PIN D5
#define ECHO_PIN D6

WiFiClient client;
String lastStatus = ""; // Menyimpan status terakhir

void setup() {
    Serial.begin(115200);
    WiFi.begin(ssid, password);
    
    pinMode(TRIG_PIN, OUTPUT);
    pinMode(ECHO_PIN, INPUT);

    Serial.println("Menghubungkan ke WiFi...");
    while (WiFi.status() != WL_CONNECTED) {
        delay(1000);
        Serial.print(".");
    }
    Serial.println("\nTerhubung ke WiFi!");
}

void loop() {
    long duration;
    int distance;

    // Kirim sinyal trigger ke sensor ultrasonik
    digitalWrite(TRIG_PIN, LOW);
    delayMicroseconds(2);
    digitalWrite(TRIG_PIN, HIGH);
    delayMicroseconds(10);
    digitalWrite(TRIG_PIN, LOW);

    // Baca waktu pantulan sinyal
    duration = pulseIn(ECHO_PIN, HIGH);
    distance = duration * 0.034 / 2; // Konversi ke cm

    Serial.print("Jarak: ");
    Serial.print(distance);
    Serial.println(" cm");

    String currentStatus = (distance < 10) ? "penuh" : "kosong";

    // Kirim data hanya jika status berubah
    if (currentStatus != lastStatus) {
        sendNotification(currentStatus);
        lastStatus = currentStatus;
    }

    delay(5000); // Cek setiap 5 detik
}

void sendNotification(String status) {
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        String postData = "status=" + status + "&id_tempat_sampah=1"; 

        http.begin(client, serverUrl);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

        int httpResponseCode = http.POST(postData);
        Serial.print("Kode Respon: ");
        Serial.println(httpResponseCode);
        
        http.end();
    } else {
        Serial.println("Gagal mengirim, tidak ada koneksi WiFi!");
    }
}
