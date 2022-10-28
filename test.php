<?php
$dsn = 'mysql:dbname=bilemo2;host=host.docker.internal;port=3306';
$user = 'root';
$password = '';

$dbh = new PDO($dsn, $user, $password);


// $link = mysqli_connect("host.docker.internal", "root", "")
//     or die("Impossible de se connecter : " . mysqli_error());
// echo 'Connexion réussie';
// mysqli_close($link);