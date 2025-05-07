<?php
session_start();
$mysqli = new MySQLI("localhost", "root", "", "movieheavenphp");

if (mysqli_connect_errno()) {
    trigger_error('Fout bij verbinding: ' . $mysqli->error);
}

$producten_in_winkelwagen = $_SESSION['winkelwagen'] ?? [];
$totaalprijs = 0;

$producten = [];

if (!empty($producten_in_winkelwagen)) {
    $ids = implode(',', array_map('intval', array_keys($producten_in_winkelwagen)));

    $query = "SELECT * FROM tblproducten WHERE productid IN ($ids)";
    $result = $mysqli->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row['aantal'] = $producten_in_winkelwagen[$row['productid']];
            $producten[] = $row;
            $totaalprijs += $row['prijs'] * $row['aantal'];
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];
    $quantity = 1; 

    if (isset($_SESSION['winkelwagen'][$productId])) {
        $_SESSION['winkelwagen'][$productId] += $quantity;
    } else {
        $_SESSION['winkelwagen'][$productId] = $quantity;
    }
    
    header("Location: portfolio.php");
    exit();
}

?>


<meta charset="UTF-8">
<meta name="description" content="Producten">
<meta name="keywords" content="Videograph, unica, creative, html">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Winkelwagen</title>

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
                        <li><a href="./login.php">Login</a></li>
                        <li><a href="./winkelwagen.php">Winkelwagen</a></li>
                    </ul>
                </nav>


    <h1>Jouw Winkelwagen</h1>

    <?php if (empty($producten)): ?>
        <p>Je winkelwagen is leeg.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0">
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
                <?php foreach ($producten as $product): ?>
                    <tr>
                        <td><img src="uploads/<?php echo htmlspecialchars($product['foto']); ?>" alt="" height="100"></td>
                        <td><?php echo htmlspecialchars($product['titel']); ?></td>
                        <td>€<?php echo number_format($product['prijs'], 2, ',', '.'); ?></td>
                        <td><?php echo $product['aantal']; ?></td>
                        <td>€<?php echo number_format($product['prijs'] * $product['aantal'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Totaal: €<?php echo number_format($totaalprijs, 2, ',', '.'); ?></h3>
        <a href="afrekenen.php" class="btn btn-primary">Verder naar afrekenen</a>
    <?php endif; ?>

    <p><a href="portfolio.php">← Verder winkelen</a></p>
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
