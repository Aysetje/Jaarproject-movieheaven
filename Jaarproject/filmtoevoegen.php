<?php
if ((isset($_POST["verzenden"])) && (isset($_POST["naam"])) && ($_POST["naam"] != "") && (isset($_POST["prijs"])) && ($_POST["prijs"] != "") && isset($_POST['beoordeling'])) {
    
    $mysqli = new MySQLi("localhost", "root", "", "movieheavenphp");

    if (mysqli_connect_errno()) {
        trigger_error('Fout bij verbinding: ' . $mysqli->error);
    } 
    else {
       

        $foto = 'placeholder.jpg'; 

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["foto"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
            
            if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $foto = basename($_FILES["foto"]["name"]);
                } else {
                    
                    echo "Er is een fout bij het uploaden van de afbeelding.";
                }
            } else {
                echo "Alleen afbeeldingen zijn toegestaan.";
            }
        } else {
            
            $foto = 'placeholder.jpg';
        }


        $sql = "INSERT INTO tblproducten (titel, omschrijving, prijs, categorieid, foto, beoordeling, aantalinvoorraad) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('ssdisis', $_POST['naam'], $_POST['omschrijving'], $_POST['prijs'], $_POST['categorieid'], $foto, $_POST['beoordeling'], $_POST['aantalinvoorraad']);


            
            if (!$stmt->execute()) {
                echo 'Het uitvoeren van de query is mislukt: ' . $stmt->error;
            } else {
                header("Location:portfolio.php");
                exit();
            }
            $stmt->close();
        } else {
            echo 'Er zit een fout in de query: ' . $mysqli->error;
        }
    }
}

$categories = [
    1 => 'Actie',
    2 => 'Drama',
    3 => 'Horror',
    4 => 'Mysterie',
    5 => 'Komedie',
    6 => 'Fantasie',
    7 => 'Romantiek',
    8 => 'Thriller',
    9 => 'Science Fiction',
    10 => 'Avontuur'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
     form {
    width: 100%;
    max-width: 700px;
    margin: 0 auto;


    padding: 25px;
    background-color: #E8D0FF;
    border-radius: 12px;

    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

label {
    display: block;
    font-weight: normal;
    margin-bottom: 8px;
    color: #6A4C9C;
    font-size: 18px;
}

input, textarea, button {
    width: 100%;
    padding: 14px;
    margin-bottom: 20px;

    border: 2px solid #9A66B8;
    border-radius: 8px;


    font-size: 15px;
    color: #4C387D;
    background-color: #F2E0FF;
}

textarea {
    resize: vertical;
    min-height: 120px;
}

button {
    
    background-color: #9A66B8;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
    border-radius: 8px;
    padding: 14px;
    transition: background-color 0.3s ease;
    
}

button:hover {
    background-color: #7C4D9D;
    
}
header {
    border-bottom: none !important; 
    box-shadow: none !important; 
}

    </style>

<meta charset="UTF-8">
    <meta name="description" content="Film toevoegen">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Film Toevoegen</title>

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
                        <h2>Film Toevoegen</h2>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <span>Film Toevoegen</span>
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
    
        <div class="row">
        
    <form action="filmtoevoegen.php" method="POST" enctype="multipart/form-data">
    
    
    <label>Titel:</label>
        <input type="text" id="naam" name="naam" required><br>

        <label>Omschrijving:</label>
        <textarea id="omschrijving" name="omschrijving" required></textarea><br>

        <label >Prijs:</label>

        <input type="number" id="prijs" name="prijs" required><br>


        <br>
        <label>Categorie:</label>
        <select id="categorieid" name="categorieid" required>
            <?php
            foreach ($categories as $key => $value) {
                $selected = ($key == $categorieid) ? 'selected' : '';
                echo "<option value='$key' $selected>$value</option>";
            }
            ?>
        </select><br>
        

        <label>Afbeelding:</label>
        <input type="file" id="foto" name="foto" accept="image/*"><br>


        <label >Beoordeling:</label>

        <input type="number" id="beoordeling" name="beoordeling" min="1" max="5"><br>

        <label>Aantal in voorraad:</label>

        <input type="number" id="aantalinvoorraad" name="aantalinvoorraad" required><br>

        <button type="submit" name="verzenden">Toevoegen</button>
    </form>
            
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