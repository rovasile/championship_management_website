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



$tara="";
$nume="";
$cea_mai_buna_pozitie="";
$grand_prix="";
$data_nasterii="";
$puncte="";
$nume="";
//print_r($_POST);

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) //se verifica daca formularul a fost trimis, si daca da, atunci se salveaza datele introduse si se folosesc pentru a introduce un sofer nou in baza de date
{

  $nume=mysqli_real_escape_string($conn,$_POST['nume']);
  $tara=mysqli_real_escape_string($conn,$_POST['tara']);
  $cea_mai_buna_pozitie=mysqli_real_escape_string($conn,$_POST['cea_mai_buna_pozitie']);
  $podiumuri=mysqli_real_escape_string($conn,$_POST['podiumuri']);
  $grand_prix=mysqli_real_escape_string($conn,$_POST['grand_prix']);
  $data_nasterii=mysqli_real_escape_string($conn,$_POST['data_nasterii']);
  $puncte=mysqli_real_escape_string($conn,$_POST['puncte']);
  $echipa = mysqli_real_escape_string($conn,$_POST['nume_echipa']);


    $queryEchipa= "SELECT id_echipa FROM echipe WHERE nume_echipa='$echipa'";   //se gaseste id-ul echipei
    $result = mysqli_query($conn, $queryEchipa);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $id_echipa=$row['id_echipa'];


  $queryUpdate = "INSERT INTO soferi (nume, tara, cea_mai_buna_pozitie, podiumuri, grand_prix, data_nasterii, puncte, id_echipa)
  VALUES('$nume','$tara','$cea_mai_buna_pozitie','$podiumuri','$grand_prix','$data_nasterii','$puncte','$id_echipa')";

  if (mysqli_query($conn, $queryUpdate)) {
    echo "Core record added successfully";
  } else {
    echo "Error updating added record: " . mysqli_error($conn);
  }





}

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
    <title>Adaugare sofer</title>
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



      echo '<div class="col-md-4 col-md-offset-4 right  ">';
      echo '<div class="sofer">';
        echo 'Adaugare sofer:';
        echo "<form action='#' method='post'>";
          echo "Nume: <input type=text id='nume' name='nume' value=''><br><br>";
          echo "Puncte: <input type=text id='puncte' name='puncte' value=''><br><br>";
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


          echo "Tara: <input type=text id='tara' name='tara' value=''><br><br>";
          echo "Cel mai bun rezultat: <input type=text id='cea_mai_buna_pozitie' name='cea_mai_buna_pozitie' value=''><br><br>";
          echo "Podiumuri: <input type=text id='podiumuri' name='podiumuri' value=''><br><br>";
          echo "Participari la campionate Grand Prix: <input type=text id='grand_prix' name='grand_prix' value=''><br><br>";
          echo "Data nasterii: <input type=text id='data_nasterii' name='data_nasterii' value=''><br><br>";
          echo "<input type='submit' value='Adauga'></input>";

        echo "</form>";

      echo '</div>';
      echo '</div>';






 ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
