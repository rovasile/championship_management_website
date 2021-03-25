<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, 'formula1');
$query= "SELECT * FROM campionat";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$id_campionat=$row['id_campionat'];
$campionat_name=$row['nume'];
$campionat_locatie=$row['locatie'];
$campionat_numar_ture=$row['numar_ture'];
$campionat_distanta=$row['distanta'];
$campionat_data_campionat=$row['data_campionat'];
$campionat_numar_participanti=$row['numar_participanti'];
$campionat_distanta_totala=intval($campionat_distanta)*intval($campionat_numar_ture);
//se extrage numele campionatului pentru bara de navigare

//pe pagina aceasta se afiseaza rezultatele finale, obtinute in pagina de Simulare


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

          <!--  <a href="../clasament/clasament.php"><submit value='Simuleaza'></submit></a> -->
            <div class="col-md-6">
              <br><br><br><br><br>
                <h1>Rezultate stabilite</h1>
                <form  action='../clasament/clasament.php' method="post">
                <?php
                $query= "SELECT * FROM lista_participanti LP  JOIN soferi S on LP.id_sofer=S.id_sofer  JOIN echipe E on S.id_echipa = E.id_echipa JOIN puncte_castigate PC on PC.id_participant=LP.id_participant";
                //echo $query;
                $result = mysqli_query($conn, $query);
                $nr_soferi = mysqli_num_rows($result);
                $i=1;

                while($row = mysqli_fetch_assoc($result)) {
                  echo "<h4> <b>Locul ".$row['locul_obtinut']."</b> ".$row['nume']." din echipa ".$row['nume_echipa']."</h4>";
                  echo "<h5> Puncte: ".$row['puncte_castigate']."</h5><hr>";


                }
                ?>
              </form>
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
