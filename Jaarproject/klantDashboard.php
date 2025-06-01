<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "movieheavenphp");

if (!isset($_SESSION['gebruiker_id']) || $_SESSION['functie'] !== 'klant') {
    header("Location: login.php");
    exit();
}

$klantid = $_SESSION['gebruiker_id'];
$success = $error = "";

// Gegevens bijwerken
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    if (!empty($wachtwoord)) {
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE tblklanten SET naam=?, adres=?, email=?, wachtwoord=? WHERE klantid=?");
        $stmt->bind_param("ssssi", $naam, $adres, $email, $hash, $klantid);
    } else {
        $stmt = $mysqli->prepare("UPDATE tblklanten SET naam=?, adres=?, email=? WHERE klantid=?");
        $stmt->bind_param("sssi", $naam, $adres, $email, $klantid);
    }

    if ($stmt->execute()) {
        $success = "Gegevens succesvol bijgewerkt.";
    } else {
        $error = "Fout bij bijwerken: " . $stmt->error;
    }
}

// Klantgegevens ophalen
$stmt = $mysqli->prepare("SELECT naam, adres, email FROM tblklanten WHERE klantid = ?");
$stmt->bind_param("i", $klantid);
$stmt->execute();
$stmt->bind_result($naam, $adres, $email);
$stmt->fetch();
$stmt->close();

// Facturen ophalen
$facturen = [];
if (isset($_GET['vanaf']) && isset($_GET['tot'])) {
    $vanaf = $_GET['vanaf'];
    $tot = $_GET['tot'];
    $stmt = $mysqli->prepare("SELECT * FROM tblbestellingen WHERE klantid = ? AND bestellingsdatum BETWEEN ? AND ?");
    $stmt->bind_param("iss", $klantid, $vanaf, $tot);
} else {
    $stmt = $mysqli->prepare("SELECT * FROM tblbestellingen WHERE klantid = ?");
    $stmt->bind_param("i", $klantid);
}

$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $facturen[] = $row;
}
$stmt->close();
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
    max-width: 700px;
    margin: 100px auto;
    padding: 30px;
    background: #1e1e1e;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
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
                     <h2>Welkom!</h2>

    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

    <h3>Eigen gegevens aanpassen</h3>
    <form method="post">
        <input type="text" name="naam" value="<?php echo htmlspecialchars($naam); ?>" required><br>
        <input type="text" name="adres" value="<?php echo htmlspecialchars($adres); ?>" required><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
        <input type="password" name="wachtwoord" placeholder="Nieuw wachtwoord (optioneel)"><br>
        <button type="submit" name="update">Gegevens bijwerken</button>
    </form>

    <h3>Facturen filteren op datum</h3>
    <form method="get">
        Vanaf: <input type="date" name="vanaf" required>
        Tot: <input type="date" name="tot" required>
        <button type="submit">Filteren</button>
    </form>

    <h3>Factuuroverzicht</h3>
    <?php if (count($facturen) > 0): ?>
        <table border="1">
            <tr><th>Factuurnr</th><th>Datum</th><th>Bedrag</th></tr>
            <?php foreach ($facturen as $factuur): ?>
                <tr>
                    <td><?= $factuur['factuurid']; ?></td>
                    <td><?= $factuur['datum']; ?></td>
                    <td>€<?= number_format($factuur['bedrag'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Geen facturen gevonden.</p>
    <?php endif; ?>
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


