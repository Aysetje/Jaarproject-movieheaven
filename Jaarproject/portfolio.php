<?php
session_start();
    $mysqli = new MySQLI("localhost","root","","movieheavenphp");

    if(mysqli_connect_errno()){
        trigger_error('Fout bij verbinding: ' . $mysqli->error);
    }
    else{
        
        
        
        if ($mysqli->connect_errno) {
            trigger_error('Fout bij verbinding: ' . $mysqli->connect_error);
        } else {
            $zoekterm = isset($_GET['zoekterm']) ? trim($_GET['zoekterm']) : '';
            $order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
            $sorteer = isset($_GET['sorteer']) ? $_GET['sorteer'] : '';
            $minPrijs = isset($_GET['minPrijs']) ? (float) $_GET['minPrijs'] : null;
            $maxPrijs = isset($_GET['maxPrijs']) ? (float) $_GET['maxPrijs'] : null;
        
           
            $sql = "SELECT * FROM tblproducten WHERE 1=1";
            $params = [];
            $types = "";
        
            if (!empty($zoekterm)) {
                $sql .= " AND titel LIKE ?";
                $params[] = "%$zoekterm%";
                $types .= "s";
            }
        
            if (!empty($minPrijs)) {
                $sql .= " AND prijs >= ?";
                $params[] = $minPrijs;
                $types .= "d";
            }
        
            if (!empty($maxPrijs)) {
                $sql .= " AND prijs <= ?";
                $params[] = $maxPrijs;
                $types .= "d";
            }
        
            if (!empty($sorteer)) {
                if ($sorteer == "prijs_asc") {
                    $sql .= " ORDER BY prijs ASC";
                } elseif ($sorteer == "prijs_desc") {
                    $sql .= " ORDER BY prijs DESC";
                } elseif ($sorteer == "titel_asc") {
                    $sql .= " ORDER BY titel ASC";
                } elseif ($sorteer == "titel_desc") {
                    $sql .= " ORDER BY titel DESC";
                }
            } else {
                $sql .= " ORDER BY titel ASC"; 
            }
            
        
            
            if ($stmt = $mysqli->prepare($sql)) {
                if (!empty($params)) {
                    $stmt->bind_param($types, ...$params);
                }
        
                if (!$stmt->execute()) {
                    echo "Fout bij query: " . $stmt->error;
                } else {
                    $result = $stmt->get_result();
                    $films = []; 
        
                    while ($row = $result->fetch_assoc()) {
                        $films[] = $row; 
                    }
                }
            } else {
                echo "Er zit een fout in de query: " . $mysqli->error;
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <style>
.work__text p {
    display: -webkit-box;
    -webkit-line-clamp: 3; 
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>
<link rel="stylesheet" href="portfolio.css" type="text/css">

    <meta charset="UTF-8">
    <meta name="description" content="Producten">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Producten</title>

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
                    
                    <form method="GET" action="portfolio.php" class="search-form">
                        <input type="text" name="zoekterm" placeholder="Zoek een film..." 
                               value="<?php echo isset($_GET['zoekterm']) ? htmlspecialchars($_GET['zoekterm']) : ''; ?>">
                        <button type="submit">🔍</button>

             


                    </form>
                </div> <div class="sort-container">
                <label for="sorteren">Sorteer op:</label>
                <form method="GET" action="portfolio.php" class="search-form">
                <select name="sorteer" onchange="filterFilms()">
                    <option value="">-------Selecteer-------</option>
                    <option value="prijs_asc" <?php if (isset($_GET['sorteer']) && $_GET['sorteer'] == 'prijs_asc') echo 'selected'; ?>>Prijs laag → hoog</option>
                    <option value="prijs_desc" <?php if (isset($_GET['sorteer']) && $_GET['sorteer'] == 'prijs_desc') echo 'selected'; ?>>Prijs hoog → laag</option>
                    <option value="titel_asc" <?php if (isset($_GET['sorteer']) && $_GET['sorteer'] == 'titel_asc') echo 'selected'; ?>>Titel A → Z</option>
                    <option value="titel_desc" <?php if (isset($_GET['sorteer']) && $_GET['sorteer'] == 'titel_desc') echo 'selected'; ?>>Titel Z → A</option>
                </select>
               
            </form>

            </div>
            <form method="GET" action="portfolio.php" class="search-form">
            <div class="filter-container">

                <label for="minPrijs">Min. prijs:</label>
                <input type="number" id="minPrijs" name="minPrijs" placeholder="€0" 
                    value="<?php echo isset($_GET['minPrijs']) ? htmlspecialchars($_GET['minPrijs']) : ''; ?>">

                <label for="maxPrijs">Max. prijs:</label>
                <input type="number" id="maxPrijs" name="maxPrijs" placeholder="€50" 
                    value="<?php echo isset($_GET['maxPrijs']) ? htmlspecialchars($_GET['maxPrijs']) : ''; ?>">

                <button type="submit">Filter</button>
                </div>
                
            </form>
            
            
                

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
     
   
    <!-- Portfolio Section Begin -->
    <section class="work">
    <div class="container">
    <div class="col-12 text-center mt-4">
    <a href="filmtoevoegen.php" class="btn btn-primary">Film Toevoegen</a>
    

    <div class="row">
    <?php
    if (!empty($films)) {
        foreach ($films as $film) {
            echo '<div class="work__item">
                <a href="film.php?id=' . $film['productid'] . '">
                    <img src="uploads/' . htmlspecialchars($film['foto']) . '" alt="' . htmlspecialchars($film['titel']) . '" class="img-fluid">
                    <div class="work__text">
                        <h5>' . htmlspecialchars($film['titel']) . '</h5>
                        <p>' . htmlspecialchars($film['omschrijving']) . '</p>
                        <strong>€' . number_format($film['prijs'], 2, ',', '.') . '</strong>
                    </div>
                </a>
                <form action="winkelwagen.php" method="POST">
    <input type="hidden" name="id" value="' . $film['productid'] . '">
    <input type="number" name="aantal" value="1" min="1">
    <button type="submit" class="toevoegen-knop">➕</button>
</form>

            </div>';
        }
    }
     else {
        // Toon dit als er geen films zijn gevonden
        $zoekterm_weergeven = htmlspecialchars($zoekterm);
        $zoekterm_weergeven = str_replace('%', '', $zoekterm_weergeven); 
        echo '<p class="yup"><br><br><br><br><br><br>Geen resultaten gevonden voor "' . $zoekterm_weergeven . '".</p>';
    }
    ?>
</div>
        </div>
    </div>
</section>
    <!-- Portfolio Section End -->

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
    <script>
function filterFilms() {
    let zoekterm = document.querySelector("input[name='zoekterm']").value;
    let sorteerOptie = document.querySelector("select[name='sorteer']").value;
    
    let url = new URL(window.location.href);
    url.searchParams.set('zoekterm', zoekterm);
    url.searchParams.set('sorteer', sorteerOptie);
    
    window.location.href = url.toString();
}


</script>

</body>

</html>