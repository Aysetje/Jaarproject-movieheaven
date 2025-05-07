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
    $mysqli = new MySQLi("localhost", "root", "", "movieheavenphp");
    if ($mysqli->connect_errno) {
    die('Fout bij verbinding: ' . $mysqli->connect_error);
}


}


?>
<?php
$mysqli = new MySQLi("localhost", "root", "", "movieheavenphp");

if ($mysqli->connect_errno) {
    die('Fout bij verbinding: ' . $mysqli->connect_error);
}

$categories = [];
$sql = "SELECT categorieid, categorie FROM tblcategorie";
$result = $mysqli->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[$row['categorieid']] = $row['categorie'];
    }
    $result->free();
} else {
    die("Fout bij ophalen van categorieën: " . $mysqli->error);
}
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
                echo "<option value='$key'>$value</option>";
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

    
   
</html>