
<?php

$server="cray.cs.gettysburg.edu";
$dbase="f23_5";
$user="vernte01";
$pass="vernte01";
try {
    $db = new PDO("mysql:host=$server;dbname=$dbase", $user, $pass);
}
catch(PDOException $e) {
    die("<H1>ERROR connecting to database " . $e->getMessage() . "</H1>");
}

?>



