<?php
$dsn = "mysql:host=143.106.241.1; dbname=2cti13";
$user = "2cti13";
$pwd = "Kb10091997";

try {
    $cn = new PDO($dsn, $user, $pwd);
    $cn->exec("set names utf8");
}catch(PDOException $ex){
    echo $ex->getMessage() ;
    exit();
}
?>