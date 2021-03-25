<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, 'formula1');
$query= "SELECT * FROM campionat";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$campionat_name=$row['nume'];
$campionat_locatie=$row['locatie'];
$campionat_numar_ture=$row['numar_ture'];
$campionat_distanta=$row['distanta'];
$campionat_data_campionat=$row['data_campionat'];
$campionat_numar_participanti=$row['numar_participanti'];
$campionat_distanta_totala=intval($campionat_distanta)*intval($campionat_numar_ture);

//se extrag datele despre campionat pentru a le afisat pe pagina principala si pe bara de navigare

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campionat</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function(){
  $("#navbarContainer").load("../navbar.php");
});
</script>

</head>

<body>
  <div id="navbarContainer">
  </div>
    <div class="container">
        <div class="row product">
            <div class="col-md-7">
              <br><br><br><br><br>
                <h1><?php echo $campionat_name; ?> </h1><br><br>
                <h3><?php echo 'Locatie: '.$campionat_locatie; ?> </h3>
                <h3><?php echo 'Numarul de ture: '.$campionat_numar_ture; ?> </h3>
                <h3><?php echo 'Distanta unei ture: '.$campionat_distanta.'km'; ?> </h3>
                <h3><?php echo 'Data: '.$campionat_data_campionat; ?> </h3>
                <h3><?php echo 'Numarul de participanti: '.$campionat_numar_participanti; ?> </h3>
                <h3><?php echo 'Distanta totala de parcurs: '.$campionat_distanta_totala.'km'; ?> </h3>
                <!-- se afiseaza informatiile -->

            </div>
        </div>
        <div class="page-header"></div>
        <div class="media">
            <div class="media-body"></div>
        </div>
        <div class="media">
            <div class="media-body"></div>
        </div>
    </div>
    <footer class="site-footer"></footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
