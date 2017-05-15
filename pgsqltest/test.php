<?php

$sDsn = 'pgsql:dbname=rhildred;user=rhildred;password=Secret6503;host=localhost';

$oPdo = new PDO($sDsn);
$statement=$oPdo->prepare("SELECT * FROM playground");
$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);
echo $json;