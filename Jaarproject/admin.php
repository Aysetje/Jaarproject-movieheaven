<?php
session_start();
$mysqli = new MySQLI("localhost", "root", "", "movieheavenphp");

if (mysqli_connect_errno()) {
    trigger_error('Fout bij verbinding: ' . $mysqli->error);
} else {

    // Klant toevoegen
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['naam'])) {
        $klantid = intval($next_klantid);
        $naam = $_POST['naam'];
        $adres = $_POST['adres'];
        $postcodeid = $_POST['postcodeid'];
        $email = $_POST['email'];

        $insert_sql = "INSERT INTO tblklanten (klantid, naam, adres, postcodeid, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insert_sql);
        $stmt->bind_param("issss", $klantid, $naam, $adres, $postcodeid, $email);
        $stmt->execute();
    }
    // Klant gegevens wijzigen
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $klantid = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $naam = $_POST['naam'];
            $adres = $_POST['adres'];
            $postcodeid = $_POST['postcodeid'];
            $email = $_POST['email'];

            $update_sql = "UPDATE tblklanten SET naam = ?, adres = ?, postcodeid = ?, email = ? WHERE klantid = ?";
            $stmt = $mysqli->prepare($update_sql);
            $stmt->bind_param("sssss", $naam, $adres, $postcodeid, $email, $klantid);
            $stmt->execute();
        }
    }

    // Volgende klant ID ophalen
    $next_klantid_sql = "SELECT MAX(klantid) AS max_id FROM tblklanten";
    $next_klantid_result = $mysqli->query($next_klantid_sql);
    $next_klantid = 1; // Standaard naar 1 als er geen klanten zijn
    if ($next_klantid_result) {
        $row = $next_klantid_result->fetch_assoc();
        $next_klantid = $row['max_id'] + 1;
    }
    // Product verbergen
    if (isset($_GET['action']) && $_GET['action'] === 'hide' && isset($_GET['id'])) {
        $productid = $_GET['id'];
        $hide_sql = "UPDATE tblproducten SET is_hidden = 1 WHERE productid = ?";
        $stmt = $mysqli->prepare($hide_sql);
        $stmt->bind_param("i", $productid);
        $stmt->execute();
    }
        // Producten ophalen
        $sql = "SELECT productid, titel, omschrijving, prijs, categorieid, beoordeling, aantalinvoorraad FROM tblproducten";
        $producten = $mysqli->query($sql);

    // Klanten ophalen
    $klanten_sql = "SELECT * FROM tblklanten";
    $klanten_result = $mysqli->query($klanten_sql);
    
    $categories = [];
    $categorie_sql = "SELECT categorieid, categorie FROM tblcategorie";
    $categorie_result = $mysqli->query($categorie_sql);
    while ($row = $categorie_result->fetch_assoc()) {
        $categories[$row['categorieid']] = $row['categorie'];
    }
}
?>


<!DOCTYPE html>
<html lang="zxx">

<head>
<link rel="stylesheet" href="admin.css" type="text/css">
    <meta charset="UTF-8">
    <meta name="description" content="Homepage">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Pagina</title>

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
                                <li> <a href="logout.php">Uitloggen</a></li>
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
            
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                    
                    <body>
                            <h2>Welkom, Admin!</h2>
                            <h4>Je bent ingelogd als beheerder.</h4>
                            
                    </body>
                        </div>
                    </div>
        </div>
    </div>
     
    <!-- Breadcrumb End -->
     <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="img/breadcrumb-bg.jpg">
         <!-- Klantenbeheer Begin -->
    <section class="klanten-beheer">
        <div class="container">
            <h4>Klanten Beheer</h4>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="klantid">Klant ID:</label>
                    <input type="text" class="form-control" id="klantid" name="klantid" value="<?php echo $next_klantid; ?>" readonly>

                </div>
                <div class="form-group">
                    <label for="naam">Naam:</label>
                    <input type="text" class="form-control" id="naam" name="naam" required>
                </div>
                <div class="form-group">
                    <label for="adres">Adres:</label>
                    <input type="text" class="form-control" id="adres" name="adres" required>
                </div>
                <div class="form-group">
                    <label for="postcodeid">Postcode ID:</label>
                    <input type="text" class="form-control" id="postcodeid" name="postcodeid" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary">Klant Toevoegen</button>
            </form>

            <h4>Bestaande Klanten</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Klant ID</th>
                        <th>Naam</th>
                        <th>Adres</th>
                        <th>Postcode ID</th>
                        <th>Email</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if ($klanten_result->num_rows > 0): ?>
                        <?php while ($klant = $klanten_result->fetch_assoc()): ?>
                            <tr>
                            
                            <td contenteditable="true" onBlur="updateKlant(<?php echo $klant['klantid']; ?>, 'klantid', this.innerText)"><?php echo $klant['klantid']; ?></td> 
                    
                            <td contenteditable="true" onBlur="updateKlant(<?php echo $klant['klantid']; ?>, 'naam', this.innerText)"><?php echo htmlspecialchars($klant['naam']); ?>
                            <td contenteditable="true" onBlur="updateKlant(<?php echo $klant['klantid']; ?>, 'adres', this.innerText)"><?php echo htmlspecialchars($klant['adres']); ?></td>
                            <td contenteditable="true" onBlur="updateKlant(<?php echo $klant['klantid']; ?>, 'postcodeid', this.innerText)"><?php echo htmlspecialchars($klant['postcodeid']); ?></td>
                            <td contenteditable="true" onBlur="updateKlant(<?php echo $klant['klantid']; ?>, 'email', this.innerText)"><?php echo htmlspecialchars($klant['email']); ?></td>

                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Geen klanten gevonden.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- Klantenbeheer Eind -->
            
                
    <section class="producten-overzicht">
        <div class="container">
            <h4>Producten Overzicht</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Titel</th>
                        <th>Omschrijving</th>
                        <th>Prijs</th>
                        <th>Categorie</th>
                        <th>Beoordeling</th>
                        <th>Aantal in voorraad</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php if ($producten && $producten->num_rows > 0): ?>
                        <?php while ($row = $producten->fetch_assoc()): ?>
                            <tr>
                            <td><?php echo $row['productid']; ?></td>
                            <td><?php echo htmlspecialchars($row['titel']); ?></td>
                            <td><?php echo htmlspecialchars($row['omschrijving']); ?></td>
                            <td>€<?php echo number_format($row['prijs'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars(isset($categories[$row['categorieid']]) ? $categories[$row['categorieid']] : 'Onbekend'); ?></td>
                            <td><?php echo $row['beoordeling']; ?> / 5</td>
                            <td><?php echo $row['aantalinvoorraad']; ?></td>
                                
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Geen producten gevonden.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- Producten Overzicht Eind -->

   


  
    <!-- Footer Section Begin -->
    <footer id="foot">
        <div class="container">
            
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
  <script>  function updateKlant(klantid, veld, waarde) {
    fetch('update_klant.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `klantid=${klantid}&veld=${veld}&waarde=${encodeURIComponent(waarde)}`
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Controleer wat de server terugstuurt
        if (!data.success) {
            alert("Fout: " + data.message);
        } else {
            console.log("Klant succesvol bijgewerkt!");
        }
    })
    .catch(error => console.error('Error:', error));
}

</script>
</body>

</html>
