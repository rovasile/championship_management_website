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

$mesaj="";

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['nume_echipa']!="") //se foloseste acel camp pentru a selecta echipa pentru care se doreste a se gasi numarul de soferi
{$queryName =mysqli_real_escape_string($conn, $_POST['nume_echipa']);
  $query= "SELECT count(S.id_sofer) as 'numar' FROM soferi S LEFT JOIN echipe E on S.id_echipa = E.id_echipa GROUP BY E.id_echipa, E.nume_echipa having E.nume_echipa LIKE '%{$queryName}%' ";
  //  echo $query;
  $result=mysqli_query($conn, $query);
  $nrSoferi = mysqli_fetch_array($result,MYSQLI_ASSOC);
  //print_r($nrSoferi);
  $mesaj="Echipa are ".$nrSoferi['numar']." soferi.";
  $_POST = array();
}



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
              <h2>Statistici despre campionat si despre soferi </h2>
              <br>

              <?php
              $queryMedie = "SELECT COUNT(id_sofer) as 'numar',(SELECT AVG(puncte) FROM soferi) AS 'medie'  FROM soferi WHERE puncte<(SELECT AVG(puncte) FROM soferi) ";  //se obtine numarul de soferi cu punctele sub medie
              $resultMedie = mysqli_query($conn, $queryMedie);
              $rowMedie =  mysqli_fetch_assoc($resultMedie);
              echo "<h3> ".$rowMedie['numar']." dintre soferi au sub media de ".$rowMedie['medie']." puncte. </h3>";


              $queryTara = "SELECT COUNT(id_sofer) AS 'numar', tara  FROM soferi group by tara order by  COUNT(id_sofer) DESC LIMIT 1"; //se obtine tara cu cei mai multi jucatori
              $resultTara = mysqli_query($conn, $queryTara);
              $rowTara =  mysqli_fetch_assoc($resultTara);

              echo "<h3> Tara cu cei mai multi soferi este ".$rowTara['tara'].", avand ".$rowTara['numar']." soferi. </h3>";
              ?>

              <form  action='#' method="post" style="margin-right:10%; font-size:20px; float:right;">
              <?php
              echo "<text style='font-size:20px'>Alegeti o echipa pentru a afla cati soferi detine: </text>";
              echo "<select id='nume_echipa' name='nume_echipa' style='color:black;' onchange='this.form.submit()'>";
              echo "<option value=''></option>";
              $queryEchipa= "SELECT nume_echipa FROM echipe";
              $resultEchipa = mysqli_query($conn, $queryEchipa);
              while($rowSelect  = mysqli_fetch_assoc($resultEchipa))
              {
                $numeAux=$rowSelect['nume_echipa'];
                if ($queryName==$numeAux)
                echo "<option value='$numeAux' selected >$numeAux</option>";
                else {
                  echo "<option value='$numeAux' >$numeAux</option>";
                }
              }
              echo "</select><br>";
              echo $mesaj;
              ?>

                <br><br>
              </form>
              <hr>
              <h3>test</h3>


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
