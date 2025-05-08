<?php
session_start();

if (empty($_SESSION['winkelwagen'])) {
    echo "<p>Je winkelwagen is leeg. <a href='portfolio.php'>Ga terug</a></p>";
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "movieheavenphp");
if ($mysqli->connect_errno) {
    die("Fout bij verbinden met database: " . $mysqli->connect_error);
}

$naam = "Testklant";
$adres = "Teststraat 1";
$postcodeid = 9000; 
$email = "test@klant.be";

$sql = "SELECT klantid FROM tblklanten WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($klantid);
    $stmt->fetch();
} else {
    $stmt->close();
    $sql = "INSERT INTO tblklanten (naam, adres, postcodeid, email) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssis", $naam, $adres, $postcodeid, $email);
    $stmt->execute();
    $klantid = $stmt->insert_id;
}
$stmt->close();

$sql = "INSERT INTO tblbestellingen (klantid, status, bestellingsdatum) VALUES (?, 'Voltooid', NOW())";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $klantid);
$stmt->execute();
$bestellingsid = $stmt->insert_id;
$stmt->close();

$totaal = 0;
foreach ($_SESSION['winkelwagen'] as $productid => $aantal) {
    $sql = "SELECT titel, prijs FROM tblproducten WHERE productid = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $productid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) continue;

    $product = $result->fetch_assoc();
    $titel = $product['titel'];
    $prijs = $product['prijs'];
    $subtotaal = $prijs * $aantal;
    $totaal += $subtotaal;

    $korting = 0;
    $sql = "INSERT INTO tblbestellingslijnen (bestellingsid, productid, aantal, korting, verkoopprijs)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iiidd", $bestellingsid, $productid, $aantal, $korting, $prijs);
    $stmt->execute();
    $stmt->close();
}
?>

<html>
<meta charset="UTF-8">
<meta name="description" content="Producten">
<meta name="keywords" content="Videograph, unica, creative, html">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Winkelwagen</title>
<head>

