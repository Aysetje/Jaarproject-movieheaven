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

// Klant zoeken of toevoegen
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

// Bestelling toevoegen
$sql = "INSERT INTO tblbestellingen (klantid, status, bestellingsdatum) VALUES (?, 'Voltooid', NOW())";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $klantid);
$stmt->execute();
$bestellingsid = $stmt->insert_id;
$stmt->close();

// Winkelwagen verwerken
$totaalprijs = 0;
?>
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


<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Header Section Begin -->
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option spad set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Bedankt voor je bestelling!</h2>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <span>Bedankt voor je bestelling!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <li ><a href="./portfolio.php">Producten</a></li>
                        <li><a href="./contact.html">Contact</a></li>
                        <li><a href="./login.php">Login</a></li>
                        <li class="active"><a href="./winkelwagen.php">Winkelwagen</a></li>
                    </ul>
                </nav>
                    </div>
                </div>
            </div>
        
    </div>
    <br><br>    <br><br>
    <div class="winkelwagen-wrapper">
    
    <style>
        body {
            background-color: rgb(27, 15, 78);
            color: white;
            font-family: 'Josefin Sans', sans-serif;
        }
        h1, h3 {
            text-align: center;
            margin-top: 30px;
        }
        .winkelwagen-tabel {
            margin: 30px auto;
            background-color: #3b0066;
            color: white;
            border-collapse: collapse;
            width: 80%;
            border-radius: 10px;
            overflow: hidden;
        }
        .winkelwagen-tabel th, .winkelwagen-tabel td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ffffff30;
        }
        .winkelwagen-tabel th {
            background-color: #2a004d;
        }
        img {
            max-height: 100px;
        }
        .btn {
            background-color: #6a1b9a;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #8e24aa;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
   <br><br>
    <p class="center">Je bestelling is succesvol geplaatst. Hieronder vind je een overzicht.</p>

    <table class="winkelwagen-tabel">
        <thead>
            <tr>
                <th>Afbeelding</th>
                <th>Titel</th>
                <th>Prijs</th>
                <th>Aantal</th>
                <th>Subtotaal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_SESSION['winkelwagen'] as $productid => $aantal) {
                $sql = "SELECT titel, prijs, foto FROM tblproducten WHERE productid = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("i", $productid);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) continue;

                $product = $result->fetch_assoc();
                $titel = $product['titel'];
                $prijs = $product['prijs'];
                $foto = $product['foto'];
                $subtotaal = $prijs * $aantal;
                $totaalprijs += $subtotaal;

                // Opslaan in bestellingslijnen
                $korting = 0;
                $sqlLijn = "INSERT INTO tblbestellingslijnen (bestellingsid, productid, aantal, korting, verkoopprijs) VALUES (?, ?, ?, ?, ?)";
                $stmtLijn = $mysqli->prepare($sqlLijn);
                $stmtLijn->bind_param("iiidd", $bestellingsid, $productid, $aantal, $korting, $prijs);
                $stmtLijn->execute();
                $stmtLijn->close();
                ?>
                <tr>
                    <td><img src="uploads/<?php echo htmlspecialchars($foto); ?>" alt="Productafbeelding"></td>
                    <td><?php echo htmlspecialchars($titel); ?></td>
                    <td>€<?php echo number_format($prijs, 2, ',', '.'); ?></td>
                    <td><?php echo $aantal; ?></td>
                    <td>€<?php echo number_format($subtotaal, 2, ',', '.'); ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <h3>Totaalbedrag: €<?php echo number_format($totaalprijs, 2, ',', '.'); ?></h3>

    <div class="center">
        <a href="portfolio.php" class="btn">← Terug naar de films</a>
    </div>
</body>
</html>

<?php
unset($_SESSION['winkelwagen']);
?>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/masonry.pkgd.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>