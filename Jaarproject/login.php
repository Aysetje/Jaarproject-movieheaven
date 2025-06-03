<?php
session_start();
require_once 'dbconnect.php';


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['email'];
    $password = $_POST['password'];

    
    if ($mail === "admin@gmail.com" && $password === "password123") {
        $_SESSION['functie'] = 'admin';
        $_SESSION['gebruiker_id'] = 'admin';
        header("Location: adminDashboard.php");
        exit();
    }

    
    $stmt = $mysqli->prepare("SELECT * FROM tblklanten WHERE email = ?");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();
    $gebruiker = $result->fetch_assoc();


    if ($gebruiker && password_verify($password, $gebruiker['wachtwoord'])) {
        $_SESSION['functie'] = 'klant';
        $_SESSION['gebruiker_id'] = $gebruiker['klantid'];
        header("Location: klantDashboard.php");
        exit();
    } else {
        $error = "Ongeldige gebruikersnaam of wachtwoord.";
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
    max-width: 400px;
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
                                <li><a href="./winkelwagen.php">Winkelwagen</a></li>
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
                    
                    <div class="login-container">
                    <h2>Login</h2>
                    <form method="POST">
                        <input type="email" name="email" placeholder="E-mailadres" required>
                        <input type="password" name="password" placeholder="Wachtwoord" required>
                        <button type="submit">Login</button>
                    </form>
                    <p class="error-message"><?php echo $error; ?></p>
                    <p>Nog geen account? <a href="register.php" style="color: #ff4c4c;">Registreer hier</a></p>

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




  