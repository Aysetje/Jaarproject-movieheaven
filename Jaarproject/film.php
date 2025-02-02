<?php
$mysqli = new MySQLI("localhost", "root", "", "movieheavenphp");

if (mysqli_connect_errno()) {
    trigger_error('Fout bij verbinding: ' . $mysqli->error);
} 
else {
    if (isset($_GET['id'])) {
        $productid = $_GET['id'];
    } else {
        $productid = 0;
    }

$sql = "SELECT * FROM tblproducten WHERE productid = ?";

}

if ($stmt = $mysqli->prepare($sql)) {

    $stmt->bind_param("i", $productid);

    $stmt->execute();


    $stmt->bind_result($id, $titel, $omschrijving, $prijs,$categorieid, $foto,  $beoordeling, $aantalinvoorraad);
    $stmt->fetch();
}

else {
    echo "Er is een fout met de query.";
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
<style>.film-detail {
    background-color: #1C1854; 
    padding: 50px 0;
}


.film-detail img {
    max-width: 85%; 
    height: auto; 
    margin-bottom: 20px; 
}


.film-detail h2 {
    color: white; 
    font-size: 2.5em; 
    font-weight: bold;
}

.film-detail p {
    color: white; 
    font-size: 1.2em; 
    line-height: 1.6;
}
header {
    border-bottom: none !important; 
    box-shadow: none !important; 
}
</style>
    <meta charset="UTF-8">
    <meta name="description" content="Videograph Template">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Videograph | Template</title>

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
                                <li class="active"><a href="./portfolio.php">Producten</a></li>
                                <li><a href="./contact.html">Contact</a></li>
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
                        <h2>Producten</h2>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <span>Producten</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
     
    <!-- Film Detail Section Begin -->
    <section class="film-detail spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img src="uploads/<?php echo $foto; ?>" alt="<?php echo $titel; ?>" class="img-fluid">
                </div>
                <div class="col-lg-6">
                    <h2><?php echo $titel; ?></h2>
                    <p><strong>Prijs:</strong> €<?php echo $prijs; ?></p>
                    <p><strong>Omschrijving:</strong> <?php echo $omschrijving; ?></p>
                    <p><strong>Beoordeling:</strong> <?php echo $beoordeling; ?> / 5</p>
         </p><?php echo '<a href="filmwijzigen.php?id=' . $productid . '" class="btn btn-primary">Film Wijzigen</a>'; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Film Detail Section End -->
   

    <!-- Footer Section Begin -->
    <footer class="footer">
        
            <div class="footer__copyright">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p class="footer__copyright__text">Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            All rights reserved | This template is made with <i class="fa fa-heart-o"
                                aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

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
   

  