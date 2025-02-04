<?php
    $mysqli = new MySQLI("localhost","root","","movieheavenphp");

    if(mysqli_connect_errno()){
        trigger_error('Fout bij verbinding: ' . $mysqli->error);
    }
    else{
        $zoekterm = isset($_GET['zoekterm']) ? trim($_GET['zoekterm']) : '';

        
        $sql = "SELECT * FROM tblproducten";
        if (!empty($zoekterm)) {
            $sql .= " WHERE titel LIKE ?";
        }

        if($stmt = $mysqli->prepare($sql)) {
            if (!empty($zoekterm)) {
                $zoekterm = "%$zoekterm%";
                $stmt->bind_param("s", $zoekterm);
            }
            if(!$stmt->execute()){
                echo "Het uitvoeren van de query is mislukt: ". $stmt->error. " in query: " . $sql;
            }
            else{
                $stmt->bind_result($productid, $titel,$omschrijving,$prijs,$categorieid,$foto,$beoordeling,$aantalinvoorraad);
                
              
            }
           
        }
    
        else{ echo "Er zit een fout in de query: " . $mysqli->error;}
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

.work__item {
    width: 100%;
    max-width: 300px; 
    margin: 42px 40px;
    margin-bottom: 90px;
}


.work__text p {
    font-size: 14px;
    color: #555; 
}

.work__text strong {
    font-size: 16px;
    color: #FFFFFF;
}
header {
    border-bottom: none !important; 
    box-shadow: none !important; 
}


.header__nav__option {
    display: flex;
    align-items: center;
    justify-content: flex-end; 
    gap: 20px; 
}

.search-form {
    display: flex;
    align-items: center;
}

.search-form input {
    padding: 8px;
    border: 2px solid #9A66B8;
    border-radius: 8px;
    outline: none;
    font-size: 14px;
    width: 200px;
}

.search-form button {
    background: #9A66B8;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 8px;
    margin-left: 5px;
    transition: background-color 0.3s;
}

.search-form button:hover {
    background: #7C4D9D;
}

.yup{margin: 0 auto;
    text-align: center; font-size: 21px;}



</style>


    <meta charset="UTF-8">
    <meta name="description" content="Producten">
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
                    
                    <form method="GET" action="portfolio.php" class="search-form">
                        <input type="text" name="zoekterm" placeholder="Zoek een film..." 
                               value="<?php echo isset($_GET['zoekterm']) ? htmlspecialchars($_GET['zoekterm']) : ''; ?>">
                        <button type="submit">🔍</button>
                    </form>
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
     
   
    <!-- Portfolio Section Begin -->
    <section class="work">
    <div class="container">
    <div class="col-12 text-center mt-4">
    <a href="filmtoevoegen.php" class="btn btn-primary">Film Toevoegen</a>
    

        <div class="row">
        <?php   $films_gevonden = false;
            while($stmt->fetch()){ 
                $films_gevonden = true;
                echo '<div class="work__item">   
             <a href="film.php?id=' . $productid . '">
                 <img src="uploads/' . htmlspecialchars($foto) . '" alt="' . htmlspecialchars($titel) . '" class="img-fluid">
                         <div class="work__text">
                                <h5>' . htmlspecialchars($titel) . '</h5>
                                <p>' . htmlspecialchars($omschrijving) . '</p>
                            <strong>€' . number_format($prijs, 2, ',', '.') . '</strong>
                            </div>   
                        </a>
                    </div>';
            }
            
            if (!$films_gevonden) {
                
                $zoekterm_weergeven = htmlspecialchars($zoekterm);
                $zoekterm_weergeven = str_replace('%', '', $zoekterm_weergeven); 
                
                echo '<p class="yup"><br><br><br><br><br><br>Geen resultaten gevonden voor "' . $zoekterm_weergeven . '".</p>';
                
            }
             ?> <br><br><br><br><br><br><br><br><br><br><br>

            
            
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
</body>

</html>