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
//se extrage numele campionatului pentru bara de navigare

$id = $_GET['id'];


$tara="";
$nume="";
$cea_mai_buna_pozitie="";
$grand_prix="";
$data_nasterii="";
$puncte="";
$nume="";
//print_r($_POST);

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['btnDelete'])) //se verifica daca a fost trimis un vector POST si daca butonul de delete nu a fost apasat
{// daca da, atunci se memoreaza datele din formular si urmeaza sa fi inlocuite in baza de date
  //initial verifica daca echipa introdusa exista deja, si daca nu, ar fi creat o alta echipa, insa la laborator a fost discutata pe scurt problema si s-a propus folosirea
  //unui drop down list, dar nu am modificat codul pentru a sterge partile nefolosite.

  $nume=mysqli_real_escape_string($conn,$_POST['nume']);
  $tara=mysqli_real_escape_string($conn,$_POST['tara']);
  $cea_mai_buna_pozitie=mysqli_real_escape_string($conn,$_POST['cea_mai_buna_pozitie']);
  $podiumuri=mysqli_real_escape_string($conn,$_POST['podiumuri']);
  $grand_prix=mysqli_real_escape_string($conn,$_POST['grand_prix']);
  $data_nasterii=mysqli_real_escape_string($conn,$_POST['data_nasterii']);
  $puncte=mysqli_real_escape_string($conn,$_POST['puncte']);
  $echipa = mysqli_real_escape_string($conn,$_POST['nume_echipa']);

  $queryUpdate = "UPDATE soferi SET nume='$nume', tara='$tara', cea_mai_buna_pozitie='$cea_mai_buna_pozitie', podiumuri='$podiumuri', grand_prix='$grand_prix', data_nasterii='$data_nasterii', puncte='$puncte' WHERE id_sofer = '$id' ";

  if (mysqli_query($conn, $queryUpdate)) {
    echo "Core record updated successfully";
  } else {
    echo "Error updating core record: " . mysqli_error($conn);
  }

  $queryEchipa= "SELECT id_echipa FROM echipe WHERE nume_echipa='$echipa'";
  $result = mysqli_query($conn, $queryEchipa);
  $nr = mysqli_num_rows($result);

  if ($nr==1)
  {

    echo "Echipa existenta.";
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      //print_r($row);


      $id_echipa=$row['id_echipa'];
      $queryUpdate = "UPDATE soferi SET id_echipa='$id_echipa' WHERE id_sofer = '$id' ";
      if (mysqli_query($conn, $queryUpdate)) {
        echo "Team updated successfully";
      } else {
        echo "Error updating team: " . mysqli_error($conn);
      }
  }
  else {
    echo "Echipa inexistenta. Se va crea.";
    $queryInsert = "INSERT INTO echipe (nume_echipa) VALUES('$echipa')";
    if (mysqli_query($conn, $queryInsert)) {
      echo "Team added successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $queryEchipa= "SELECT id_echipa FROM echipe WHERE nume_echipa='$echipa'";
    $result = mysqli_query($conn, $queryEchipa);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $id_echipa=$row['id_echipa'];
    $queryUpdate = "UPDATE soferi SET id_echipa='$id_echipa' WHERE id_sofer = '$id' ";
    if (mysqli_query($conn, $queryUpdate)) {
      echo "Team updated successfully";
    } else {
      echo "Error updating team: " . mysqli_error($conn);
    }

  }



}
else if(isset($_POST['btnDelete'])){
  //daca se detecteaza ca butonul de delete a fost apasat, se va sterge inregistrarea curenta
$queryDelete = "DELETE FROM soferi WHERE id_sofer='$id'";
$resultDelete = mysqli_query($conn, $queryDelete);
if ($resultDelete) {
header('Location: ../soferi/soferi.php');
} else {
  echo "Error deleting record: " . mysqli_error($conn);
}

}

//se extrag datele despre soferul ales. vor fi mai tarziu utilizate pentru a popula formularul
$query= "SELECT * FROM soferi S LEFT JOIN echipe E on S.id_echipa = E.id_echipa WHERE id_sofer='$id'";
$result = mysqli_query($conn, $query);

?>



<!DOCTYPE html>
<html>

<head>
  <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil sofer</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function(){
  $("#navbarContainer").load("../navbar.php");
});
</script>

<style>
.col-md-3{
  margin-left: 120px;
}

.sofer{
  border: 2px solid rgb(0,0,0);
  border-radius: 0px 100px 0px 100px;
  background-color: #c70007;
  color: white;
  font-size: 19px;
  text-align: center;
  padding-bottom: 20px;
  box-shadow: 5px 5px 10px black,
              -3px -3px 10px purple;
}
.sofer h4{

  font-size: 35px;
  text-shadow: 1px -1px 1px #DDD;
}

hr{ width:70%; height:2px; background-color:black; }

.right .sofer{
  text-align: right;
  padding-right: 35px;
    border-radius: 5px 5px 5px 5px;
}

.right .sofer input{
color:black;
}


</style>

</head>

<body>
  <div id="navbarContainer">
  </div>
    <br><br><br>

<?php

if (mysqli_num_rows($result) > 0) {
$i=0;
  while($row = mysqli_fetch_assoc($result)) {




      echo '<div class="col-md-3 col-md-offset-1">';
      echo '<div class="sofer">';
        echo '<h4>'.$row['nume'].'</h4><hr/>';
        echo '<p> Puncte: '.$row['puncte'].'<p>';
        echo '<p> Echipa: '.$row['nume_echipa'].'<p>';
        echo '<p> Tara: '.$row['tara'].'<p>';
        echo '<p> Cel mai bun rezultat: '.$row['cea_mai_buna_pozitie'].'<p>';
        echo '<p> Podiumuri: '.$row['podiumuri'].'<p>';
        echo '<p> Participari la campionate Grand Prix: '.$row['grand_prix'].'<p>';
        echo '<p> Data nasterii: '.$row['data_nasterii'].'<p>';
      echo '</div>';
      echo '</div>';


      echo '<div class="col-md-4 col-md-offset-1 right  ">';
      echo '<div class="sofer">';
        echo 'Schimbare date:';
        echo "<form action='#' method='post'>";
          echo "Nume: <input type=text id='nume' name='nume' value='".$row['nume']."'><br><br>";
          echo "Puncte: <input type=text id='puncte' name='puncte' value='".$row['puncte']."'><br><br>";
        //  echo "Nume echipa: <input type=text id='nume_echipa' name='nume_echipa' value='".$row['nume_echipa']."'><br><br>";

          echo "Nume echipa: ";
          echo "<select id='nume_echipa' name='nume_echipa' style='color:black;'>";
          $queryEchipa= "SELECT nume_echipa FROM echipe";
          $result = mysqli_query($conn, $queryEchipa);
          while($rowSelect = mysqli_fetch_assoc($result))
          {
            $numeAux=$rowSelect['nume_echipa'];
            if ($row['nume_echipa']==$numeAux)
          echo "<option value='$numeAux' selected >$numeAux</option>";
          else {
            echo "<option value='$numeAux' >$numeAux</option>";
          }

        }

          echo "</select><br><br>";


          echo "Tara: <input type=text id='tara' name='tara' value='".$row['tara']."'><br><br>";
          echo "Cel mai bun rezultat: <input type=text id='cea_mai_buna_pozitie' name='cea_mai_buna_pozitie' value='".$row['cea_mai_buna_pozitie']."'><br><br>";
          echo "Podiumuri: <input type=text id='podiumuri' name='podiumuri' value='".$row['podiumuri']."'><br><br>";
          echo "Participari la campionate Grand Prix: <input type=text id='grand_prix' name='grand_prix' value='".$row['grand_prix']."'><br><br>";
          echo "Data nasterii: <input type=text id='data_nasterii' name='data_nasterii' value='".$row['data_nasterii']."'><br><br>";
          echo "<input type='submit' value='Update'></input>";
          echo "<input type='submit' value='Delete' name='btnDelete'></input>";

        echo "</form>";

      echo '</div>';
      echo '</div>';


  }

}



 ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
