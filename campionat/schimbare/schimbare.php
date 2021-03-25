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

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['username']!="") //se foloseste acel camp pentru a selecta echipa pentru care se doreste a se gasi numarul de soferi
{
  session_start();
  $username=$_POST['username'];
  $updateUsername = "UPDATE login SET username='".$username."' WHERE id='".$_SESSION['id']."'";
  $result = mysqli_query($conn, $updateUsername);
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
              <h2>Schimbare username:</h2>
              <br>

              <form  action='#' method="post" style="margin-right:10%; font-size:20px; float:right;">
              <?php
              echo "<text style='font-size:20px'>Alegeti un username nou: </text>";
              echo "<input type='text' name='username'>";
              echo "<input type='submit'>";

              echo "</select><br>";
              echo $mesaj;
              ?>

                <br><br>
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
