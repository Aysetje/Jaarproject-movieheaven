<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "movieheavenphp");
if (!isset($_SESSION['gebruiker_id']) || $_SESSION['functie'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$adminid = $_SESSION['gebruiker_id'];

$zoekterm = $_GET['zoekterm'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_klant'])) {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];

    $stmt = $mysqli->prepare("UPDATE tblklanten SET naam=?, adres=?, email=? WHERE klantid=?");
    $stmt->bind_param("sssi", $naam, $adres, $email, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: adminDashboard.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $productid = $_POST['productid'];
    $titel = $_POST['titel'];
    $omschrijving = $_POST['omschrijving'];
    $prijs = $_POST['prijs'];
    $voorraad = $_POST['voorraad'];

    $stmt = $mysqli->prepare("UPDATE tblproducten SET titel=?, omschrijving=?, prijs=?, aantalinvoorraad=? WHERE productid=?");
    $stmt->bind_param("ssdii", $titel, $omschrijving, $prijs, $voorraad, $productid);
    $stmt->execute();
    $stmt->close();

    header("Location: adminDashboard.php");
    exit();
}
if ($zoekterm) {
    $zoekterm_wild = "%$zoekterm%";

    // Klanten
    $stmt = $mysqli->prepare("SELECT klantid, naam, adres, email FROM tblklanten WHERE naam LIKE ? OR email LIKE ?");
    $stmt->bind_param("ss", $zoekterm_wild, $zoekterm_wild);
    $stmt->execute();
    $klanten = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Producten
    $stmt = $mysqli->prepare("SELECT productid, titel, omschrijving, prijs, aantalinvoorraad FROM tblproducten WHERE titel LIKE ?");
    $stmt->bind_param("s", $zoekterm_wild);
    $stmt->execute();
    $producten = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Facturen
    $stmt = $mysqli->prepare("SELECT bestellingid, klantid, bestellingsdatum, status FROM tblbestellingen WHERE bestellingid LIKE ? OR bestellingsdatum LIKE ?");
    $stmt->bind_param("ss", $zoekterm_wild, $zoekterm_wild);
    $stmt->execute();
    $facturen = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $klanten = $mysqli->query("SELECT klantid, naam, adres, email FROM tblklanten")->fetch_all(MYSQLI_ASSOC);
    $producten = $mysqli->query("SELECT productid, titel, omschrijving, prijs, aantalinvoorraad FROM tblproducten")->fetch_all(MYSQLI_ASSOC);
    $facturen = $mysqli->query("SELECT bestellingid, klantid, bestellingsdatum, status FROM tblbestellingen")->fetch_all(MYSQLI_ASSOC);
}


?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <style>
        
body {
    font-family: 'Josefin Sans', sans-serif;
    background-color: #121212;
    color: #fff;
    margin: 0;
    padding: 0;
}


.login-container {
    width: 100%;
    max-width: 1000px;
    margin: 100px auto;
    padding: 30px;
    background: #1e1e1e;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(190, 68, 68, 0.1);
    text-align: center;
}


.login-container h2 {
    margin-bottom: 20px;
    font-size: 26px;
    font-weight: bold;
    border-bottom: none;
}


.login-container input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    background: #333;
    color: #fff;
}


.login-container button {
    width: 100%;
    padding: 12px;
    background: #ff4c4c;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    color: #fff;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}

.login-container button:hover {
    background: #ff1f1f;
}


.error-message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}
   
        
input, button { 
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    background: #333;
    color: #fff;
}
button { background-color: #ff4c4c; cursor: pointer; }
button:hover { background-color: #ff1f1f; }
.message { color: red; }
.success { color: purple; }

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #1e1e1e;
}

th, td {
    padding: 10px;
    border: 1px solid #444;
    text-align: center;
    vertical-align: middle;
    color: white;
}


table input[type="text"],
table input[type="email"],
table input[type="number"] {
    width: 100%;
    padding: 6px;
    box-sizing: border-box;
    border-radius: 4px;
    border: none;
    background-color: #2c2c2c;
    color: white;
}


textarea[name="omschrijving"] {
    min-width: 300px;
    height: 100px;
    overflow-y: auto;
    resize: vertical; 
    display: block;
    background-color: #1e1e1e;
    color: #fff;
}



table input[name="voorraad"] {
    width: 80px;
}


h2 + table:nth-of-type(3) td {
    text-align: left;
}


table button {
    padding: 8px 10px;
    font-size: 14px;
    background-color: #ff4c4c;
    border: none;
    border-radius: 4px;
    color: white;
    cursor: pointer;
}
table button:hover {
    background-color: #ff1f1f;
}

    </style>
    <meta charset="UTF-8">
    <meta name="description" content="Homepage">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.html"><img src="img/logo/movieheaven_logo.png" alt="" height="130px" width="140px"></a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="header__nav__option">
                        <nav class="header__nav__menu mobile-menu">
                            <ul>
                                <li><a href="./index.html">Home</a></li>
                                
                                <li><a href="./portfolio.php">Producten</a></li>
                                
                                <li ><a href="./contact.html">Contact</a></li>
                                <li class="active"><a href="./login.php">Login</a></li>
                            </ul>
                        </nav>
                       
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                    <body>
                    <div class="login-container">
<h1>Welkom, admin!</h1>

    <form method="get">
        <input type="text" name="zoekterm" placeholder="Zoeken..." value="<?= htmlspecialchars($zoekterm) ?>">
        <button type="submit">Zoeken</button>
    </form>

    <h2>Klanten</h2>
    <table>
        <tr><th>ID</th><th>Naam</th><th>Adres</th><th>Email</th><th>Acties</th></tr>
        <?php foreach ($klanten as $klant): ?>
            <tr>
                <form method="post" class="inline">
                    <td><?= $klant['klantid'] ?></td>
                    <td><input type="text" name="naam" value="<?= htmlspecialchars($klant['naam']) ?>"></td>
                    <td><input type="text" name="adres" value="<?= htmlspecialchars($klant['adres']) ?>"></td>
                    <td><input type="email" name="email" value="<?= htmlspecialchars($klant['email']) ?>"></td>
                    <td>
                        <input type="hidden" name="id" value="<?= $klant['klantid'] ?>">
                        <button type="submit" name="update_klant">Bijwerken</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>
  <h2>Producten</h2>
    <table>
        <tr><th>ID</th><th>Titel</th><th>Omschrijving</th><th>Prijs (€)</th><th>Voorraad</th></tr>
        <?php foreach ($producten as $product): ?>
        <tr>
        <form method="post" class="inline">
            <td><?= $product['productid'] ?></td>
            <td><input type="text" name="titel" value="<?= htmlspecialchars($product['titel']) ?>"></td>
            <td><textarea name="omschrijving"><?= htmlspecialchars($product['omschrijving']) ?></textarea></td>
            <td><input type="number" step="0.01" name="prijs" value="<?= htmlspecialchars($product['prijs']) ?>"></td>
            <td>
                <input type="number" name="voorraad" value="<?= $product['aantalinvoorraad'] ?>">
                <input type="hidden" name="productid" value="<?= $product['productid'] ?>">
                <button type="submit" name="update_product">Bijwerken</button>
            </td>
        </form>
    </tr>
        <?php endforeach; ?>
    </table>

    <h2>Bestellingen</h2>
    <table>
        <tr><th>Bestelling ID</th><th>Klant ID</th><th>Datum</th><th>Status</th></tr>
        <?php foreach ($facturen as $factuur): ?>
        <tr>
            <td><?= $factuur['bestellingid'] ?></td>
            <td><?= $factuur['klantid'] ?></td>
            <td><?= $factuur['bestellingsdatum'] ?></td>
            <td><?= htmlspecialchars($factuur['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Breadcrumb End -->


    <!-- Call To Action Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                
            </div>
        </div>
    </section>
    <!-- Call To Action Section End -->

    

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>

