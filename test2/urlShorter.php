<?php
require_once('db_connect.php');

$url = $_POST['URL'];
$urlShort = "";

do {
    for ($i = 0; $i < 7; $i++) {
        $letter = chr(rand(65, 90));
        $number = mt_rand(0, 9);

        if (mt_rand(0, 1) == 1) {
            $urlShort .= $letter;

        } else {
            $urlShort .= $number;
        }
    }

    $result_set = $mysqli->query("SELECT `short_url` FROM `urls` WHERE `short_url` = '$urlShort' ");

    if(!$result_set){
        $mysqli->query("INSERT INTO `urls` (`url`,`short_url`) VALUES ('$url','$urlShort')");
        echo $urlShort;
    }

}while($result_set)

?>
