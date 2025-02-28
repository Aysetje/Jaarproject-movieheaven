<?php
session_start();
$mysqli = new MySQLI("localhost", "root", "", "movieheavenphp");

if (mysqli_connect_errno()) {
    echo json_encode(["success" => false, "message" => "Database verbinding mislukt"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klantid = intval($_POST['klantid']);
    $veld = $_POST['veld'];
    $waarde = $_POST['waarde'];

    // Voorkomen van SQL-injectie: alleen toegestane velden updaten
    $allowed_fields = ['naam', 'adres', 'postcodeid', 'email'];
    if (!in_array($veld, $allowed_fields)) {
        echo json_encode(["success" => false, "message" => "Ongeldig veld"]);
        exit();
    }

    $sql = "UPDATE tblklanten SET $veld = ? WHERE klantid = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("si", $waarde, $klantid);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Update mislukt"]);
    }
}
?>
