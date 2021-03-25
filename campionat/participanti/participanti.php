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


if ( $_SERVER['REQUEST_METHOD'] == 'POST')
{
  $searchAdauga="Adauga";
  $idToAdd = array_search($searchAdauga,$_POST, true); //butoanele adauga contin ID-ul care corespunde soferului din dreptul lor, deci caut care dintre butoane a fost apasat si ce ID are stocat in el

  if($idToAdd>0)
  { $queryAddToParticipanti="INSERT INTO lista_participanti(id_sofer, id_campionat) VALUES('$idToAdd','$id_campionat')"; //se completeaza in lista_participanti cu soferul ales
    $resultAddToParticipanti=mysqli_query($conn,$queryAddToParticipanti );
  }

  $searchSterge="Sterge";
  $idToDelete = array_search($searchSterge,$_POST, true); //butoanele adauga contin ID-ul care corespunde soferului din dreptul lor, deci caut care dintre butoane a fost apasat si ce ID are stocat in el
  if($idToDelete>0)
  {
    $queryDeleteParticipant="DELETE FROM lista_participanti WHERE id_sofer='$idToDelete'";  //sterg id-ul care corespunde butonului apasat
    $resultAddToParticipanti=mysqli_query($conn,$queryDeleteParticipant );
  }



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
            <div class="col-md-6">
              <br><br><br><br><br>
                <h1>Soferi disponibili</h1>
                <form  action='#' method="post">
                <?php
                $query= "SELECT * FROM soferi S LEFT JOIN echipe E on S.id_echipa = E.id_echipa WHERE S.id_sofer NOT IN (SELECT id_sofer FROM lista_participanti) ORDER BY puncte DESC";
                $result = mysqli_query($conn, $query);
                $nr_soferi = mysqli_num_rows($result);
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<input type='submit' style='display: inline-block;' value='Adauga' name='".$row['id_sofer']."'></input>";
                  echo "<h4>".$row['nume']." din echipa ".$row['nume_echipa']."</h4><hr>";
                }
                ?>
              </form>


            </div>
          <!--  <a href="../clasament/clasament.php"><submit value='Simuleaza'></submit></a> -->
            <div class="col-md-6">
              <br><br><br><br><br>
                <h1>Soferi inscrisi in campionatul curent</h1>
                <form  action='#' method="post">
                <?php
                $query= "SELECT * FROM lista_participanti LP  JOIN soferi S on LP.id_sofer=S.id_sofer  JOIN echipe E on S.id_echipa = E.id_echipa ORDER BY S.puncte DESC";
                //echo $query;
                $result = mysqli_query($conn, $query);
                $nr_soferi = mysqli_num_rows($result);
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<input type='submit' style='display: inline-block;' value='Sterge' name='".$row['id_sofer']."'></input>";
                  echo "<h4>".$row['nume']." din echipa ".$row['nume_echipa']."</h4><hr>";
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
