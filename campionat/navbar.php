<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$conn = mysqli_connect($servername, $dbusername, $dbpassword, 'formula1');
$query= "SELECT * FROM campionat";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$campionat_name=$row['nume'];

?>


<nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="../mainpage/mainpage.php"><?php echo $campionat_name; ?> </a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li role="presentation"><a href="../soferi/soferi.php">Soferi </a></li>
                    <li role="presentation"><a href="../soferiAdd/soferiAdd.php">Adauga Sofer </a></li>
                    <li role="presentation"><a href="../echipe/echipe.php">Echipe </a></li>
                    <li role="presentation"><a href="../participanti/participanti.php">Participanti </a></li>
                    <li role="presentation"><a href="../simulare/simulare.php">Simulare </a></li>
                    <li role="presentation"><a href="../clasament/clasament.php">Clasament </a></li>
                    <li role="presentation"><a href="../statistici/statistici.php">Statistici </a></li>
                    <li role="presentation"><a href="../schimbare/schimbare.php">Schimbare username </a></li>
                </ul>
                <a href='../'><button class="btn btn-primary navbar-btn navbar-right" type="button">LOG OFF</button></a>
            </div>
        </div>
    </nav>
