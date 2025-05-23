<?php 
session_start();
    $mysqli = new MySQLI("localhost","root","","movieheavenphp");

    if(mysqli_connect_errno()){
        trigger_error('Fout bij verbinding: ' . $mysqli->error);
    }

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $wachtwoord_herhaal = $_POST['wachtwoord_herhaal'];

    // Controleer of wachtwoorden overeenkomen
    if ($wachtwoord !== $wachtwoord_herhaal) {
        $error = "Wachtwoorden komen niet overeen.";
    } else {
        // Controleer of gebruiker al bestaat
        $stmt = $conn->prepare("SELECT * FROM klanten WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = "Er bestaat al een account met dit e-mailadres.";
        } else {
            // Versleutel wachtwoord en voeg toe aan database
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO klanten (email, wachtwoord) VALUES (?, ?)");
            if ($stmt->execute([$email, $hash])) {
                $success = "Account succesvol aangemaakt! Je kan nu <a href='login.php'>inloggen</a>.";
            } else {
                $error = "Er ging iets mis. Probeer opnieuw.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <style>
        body { background-color:rgb(41, 4, 88); font-family: 'Josefin Sans', sans-serif; color: #fff; margin-top: 230px;}
        
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
        .success { color: lightgreen; }
        .container{
    width: 100%;
    max-width: 400px;
    margin: 100px auto;
    padding: 30px;
    background: #1e1e1e;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
    text-align: center;

}
        
    </style>
</head>
<body>
    <div class="container">
        <h2>Maak een account aan</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="E-mailadres" required>
            <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
            <input type="password" name="wachtwoord_herhaal" placeholder="Herhaal wachtwoord" required>
            <button type="submit">Registreren</button>
        </form>
        <?php if ($error) echo "<p class='message'>$error</p>"; ?>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    </div>
</body>
</html>