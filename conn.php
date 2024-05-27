<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "aims"; 

try {

    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);


    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $suhu = $_POST['suhu'];
    $tds = $_POST['tds']; 
    $ph = $_POST['ph']; 

  
    $stmtSuhu = $conn->prepare("INSERT INTO suhu (tanggal, waktu, suhu) VALUES (:tanggal, :waktu, :suhu)");
    $stmtSuhu->bindParam(':tanggal', $tanggal);
    $stmtSuhu->bindParam(':waktu', $waktu);
    $stmtSuhu->bindParam(':suhu', $suhu);

    $stmtTDS = $conn->prepare("INSERT INTO ppm_air (tanggal, waktu, ppm_air) VALUES (:tanggal, :waktu, :ppm_air)");
    $stmtTDS->bindParam(':tanggal', $tanggal);
    $stmtTDS->bindParam(':waktu', $waktu);
    $stmtTDS->bindParam(':ppm_air', $tds);

    
    $stmtPH = $conn->prepare("INSERT INTO ph_air (tanggal, waktu, ph_air) VALUES (:tanggal, :waktu, :ph_air)");
    $stmtPH->bindParam(':tanggal', $tanggal);
    $stmtPH->bindParam(':waktu', $waktu);
    $stmtPH->bindParam(':ph_air', $ph);

    $stmtSuhu->execute();
    $stmtTDS->execute();
    $stmtPH->execute();

    echo "Data suhu, TDS/PPM, dan pH berhasil disimpan";
    
} catch(PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}

