<?php

$servername = "localhost"; // Ganti dengan hostname atau alamat IP server MySQL Anda
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$database = "aims"; // Ganti dengan nama database MySQL Anda

try {
    // Buat koneksi menggunakan PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // Set mode error PDO ke exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Koneksi sukses"; // Opsional: Uncomment jika ingin menampilkan pesan koneksi sukses
    
    // Ambil data suhu dari request POST Arduino
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $suhu = $_POST['suhu'];

    // Persiapkan statement SQL untuk menyimpan data suhu ke tabel suhu
    $stmt = $conn->prepare("INSERT INTO suhu (tanggal, waktu, suhu) VALUES (:tanggal, :waktu, :suhu)");
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':waktu', $waktu);
    $stmt->bindParam(':suhu', $suhu);

    // Eksekusi s tatement SQL untuk menyimpan data
    $stmt->execute();

    echo "Data suhu berhasil disimpan";
    
} catch(PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
