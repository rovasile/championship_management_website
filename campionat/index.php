<?php
 session_start();
 error_reporting( error_reporting() & ~E_NOTICE );
//print_r($_POST);
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, 'formula1');
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$password=mysqli_real_escape_string($conn, $_POST['password']);
$password=md5($password);
$username=mysqli_real_escape_string($conn, $_POST['username']);

$query= "SELECT * FROM login WHERE password = '$password' AND username='$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$count = mysqli_num_rows($result);

$message="";
if ($count==1)  //se verifica daca exista combinatia de nume si parola introduse in formular, si in caz ca da, se redirectioneaza la pagina principala
{
//login successful
session_start();
$_SESSION['id']=$row['id'];
$_SESSION['username']=$username;
header("location: ../campionat/mainpage/mainpage.php");
}
else {
  $message="The username and the password do not match.";
}


$_POST = array();

}




 ?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div id="bg-image"></div>
    <div id=main>
        <form action='#' method="post">
            <text> Username: </text> &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" autofocus="" autocomplete="on" name="username" id='username'><br><br>
            <text> Password: </text> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="password" autocomplete="off" name="password" id='password'><br><br>
            <input type="submit" id='btn' value='Log in'></input><br><br>
            <text><?php echo $message; ?></text>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
