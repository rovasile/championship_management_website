<?php
 error_reporting( error_reporting() & ~E_NOTICE );
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

$query= "SELECT * FROM echipe E LEFT JOIN sponsorizari S on S.id_echipa = E.id_echipa ORDER BY E.id_echipa";  //se obtine lista cu echipe
$mesajCautare="";

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['nume_echipa']!="")
{$queryName =mysqli_real_escape_string($conn, $_POST['nume_echipa']);
  $query= "SELECT * FROM echipe E LEFT JOIN sponsorizari S on S.id_echipa = E.id_echipa WHERE nume_echipa LIKE '%{$queryName}%' ORDER BY E.id_echipa"; //se obtine lista cu echipe in functie de nume
  $mesajCautare="Rezultate pentru ".$queryName.":";
  $_POST = array();
}


if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['sponsor']!="")
{$queryName =mysqli_real_escape_string($conn, $_POST['sponsor']);
  $query= "SELECT * FROM echipe E LEFT JOIN sponsorizari S on S.id_echipa = E.id_echipa WHERE S.nume_sponsor LIKE '%{$queryName}%' ORDER BY E.id_echipa"; //se obtine lista cu echipe in functie de sponsorul cautat
  $mesajCautare="Rezultate pentru ".$queryName.":";
  $_POST = array();
}


$result = mysqli_query($conn, $query);
$nr_soferi = mysqli_num_rows($result);





?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echipe</title>
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
body{
  //background-color: #eee;
}


</style>

</head>

<body>
  <div id="navbarContainer">
  </div>
    <br><br><br>
<div id='forms'>
<form  action='#' method="post" style="margin-left:10%; font-size:20px; float:left;">
  <text style=" font-size:30px">  Cautare dupa sponsor: </text>
  <input type="text" name="sponsor" id='sponsor'><br>
  <?php echo $mesajCautare; ?>
  <br><br>
</form>

<!--
<form  action='#' method="post" style="margin-right:10%; font-size:20px; float:right;">
  <text style=" font-size:30px">  Cautare dupa echipa: </text>
  <input type="text" name="echipa" id='echipa'><br>
  <br><br>
</form>
-->
<form  action='#' method="post" style="margin-right:10%; font-size:20px; float:right;">
<?php
echo "<text style='font-size:30px'>Cautare dupa echipa: </text>";
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
echo "</select>";
//echo $mesajCautare;
?>

  <br><br>
</form>

</div><br><br><br><br><br>

<?php
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
$i=0;
$lastName="";
$finishRow=0;
  while($row = mysqli_fetch_assoc($result)) {
    if ($i==0)
    echo '<div class="row">';





        if ($row['nume_echipa']==$lastName)
        {
          echo '<p>'.$row['nume_sponsor'].' - $'.$row['suma'].'M </p>';

        }
        else {



          $i+=1;
          if($i>1)
          {
            echo '</div>';
            echo '</div>';
          }

          if ($finishRow==1 && $i%3==1 && $i>1)
          {echo '</div><br><br>';
            echo '<div class="row">';

            $finishRow=0;
          }

          if ($i%3==0)
          $finishRow=1;

          echo '<div class="col-md-3 col-md-offset-1">';
          echo '<div class="sofer">';

          $tempQueryNrSponsori="SELECT count(S.id_sponsor) AS 'NR', sum(S.suma) AS 'SUMA' FROM echipe E LEFT JOIN sponsorizari S on S.id_echipa = E.id_echipa WHERE E.nume_echipa='".$row['nume_echipa']."' GROUP BY E.id_echipa ";
          //echo $tempQueryNrSponsori;
          $resultNrSponsori = mysqli_query($conn, $tempQueryNrSponsori);
          $rowNrSponsori = mysqli_fetch_array($resultNrSponsori,MYSQLI_ASSOC);

          echo '<h4>'.$row['nume_echipa'].'</h4>
            <h5> Numar de sponsori principali: '.$rowNrSponsori['NR'].' </h5>
            <h5> Venit din sponsorizari: $'.$rowNrSponsori['SUMA'].'M </h5>
          <hr/>';
          echo '<p>'.$row['nume_sponsor'].' - $'.$row['suma'].'M </p>';

        }
        $lastName=$row['nume_echipa'];



/*
      if ($i-1%3==2)
      echo '</div><br><br>';
*/

  }

}



 ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
