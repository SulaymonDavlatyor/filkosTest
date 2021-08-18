<?php
require_once('db_connect.php');

if($_GET['URL'] == 'localhost/main'){
    readfile('index.html');
}else{
    $url = $_GET['URL'];
    $result_set = $mysqli->query("SELECT `url` FROM `urls` WHERE `short_url` = '$url' ");


    $tableRes = [];
    while(($row = $result_set->fetch_assoc()) != false){
        $tableRes[] = $row;
    }

    $url = $tableRes[0];
    header("Location: $url ");

}




?>