<?php     $mysqli = new MySQLI("sql308.infinityfree.com","if0_38936799","au1kEh8p6r55TMJ","if0_38936799_movieheavenphp");
// $mysqli = new MySQLI("localhost","root","","movieheavenphp");
    if(mysqli_connect_errno()){
        trigger_error('Fout bij verbinding: ' . $mysqli->error);
    }
?>