<?php 
session_start();
   require_once 'dbconnect.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = isset($_POST['naam']) ? $_POST['naam'] : '';
$adres = isset($_POST['adres']) ? $_POST['adres'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$wachtwoord = isset($_POST['wachtwoord']) ? $_POST['wachtwoord'] : '';
$wachtwoord_herhaal = isset($_POST['wachtwoord_herhaal']) ? $_POST['wachtwoord_herhaal'] : '';

    // Controleer of wachtwoorden overeenkomen
    if ($wachtwoord !== $wachtwoord_herhaal) {
        $error = "Wachtwoorden komen niet overeen.";
    } else {
         // Controleer of gebruiker al bestaat
        $stmt = $mysqli->prepare("SELECT klantid FROM tblklanten WHERE email = ?");
        if (!$stmt) {
            die("Fout in prepare: " . $mysqli->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Er bestaat al een account met dit e-mailadres.";
        } else {
            // Gebruiker bestaat niet, dus account aanmaken
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

            $stmt_insert = $mysqli->prepare("INSERT INTO tblklanten (naam, adres, email, wachtwoord) VALUES (?,?,?, ?)");
            if (!$stmt_insert) {
                die("Fout in prepare insert: " . $mysqli->error);
            }
            $stmt_insert->bind_param("ssss", $naam, $adres, $email, $hash);

            if ($stmt_insert->execute()) {
                $success = "Account succesvol aangemaakt! Je kan nu <a href='login.php'>inloggen</a>.";
            } else {
                $error = "Er ging iets mis. Probeer opnieuw.". $stmt_insert->error;
            }

            $stmt_insert->close();
        }

        $stmt->close();
    }
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
                     <h2>Maak een account aan</h2>
        <form method="POST">
             <input type="text" name="naam" placeholder="Naam" required>
            <input type="text" name="adres" placeholder="Adres" required>
            <input type="email" name="email" placeholder="E-mailadres" required>
            <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
            <input type="password" name="wachtwoord_herhaal" placeholder="Herhaal wachtwoord" required>
            <button type="submit">Registreren</button>
        </form>
        <?php if ($error) echo "<p class='message'>$error</p>"; ?>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>

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
