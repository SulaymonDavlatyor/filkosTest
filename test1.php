<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_NAME = 'testFilkos1';
const DB_PASSWORD = 'root';

$productList = ['product_1','product_2','product_3','product_4'];
$customersList = ['Ivan','Andrey','Kirill','Denis'];

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);


$mysqli->query('CREATE TABLE `testfilkos1`.`products` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB');
$mysqli->query('CREATE TABLE `testfilkos1`.`customers` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;');
$mysqli->query('CREATE TABLE `testfilkos1`.`orderhistory` ( `order_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `product_id` INT UNSIGNED NOT NULL , `customer_id` INT UNSIGNED NOT NULL , PRIMARY KEY (`order_id`)) ENGINE = InnoDB;');


$queryProducts = "INSERT INTO `products` (`id`,`name`) VALUES ";
foreach($productList as $product){
    $queryProducts .= "(NULL, '$product' )";
    if(next($productList)){
       $queryProducts .= ',';
    }
}


$queryCustomers = "INSERT INTO `customers` (`id`,`name`) VALUES ";
foreach($customersList as $customer){
    $queryCustomers .= "(NULL,'$customer')";
    if(next($customersList)){
        $queryCustomers .= ',';
    }
}

$queryOrders = "INSERT INTO `orderhistory` (`order_id`, `product_id`, `customer_id`)
                VALUES (NULL, '1', '2'), (NULL, '4', '2'),(NULL, '2', '2'),(NULL, '3', '2'),
                       (NULL, '1', '3'),(NULL, '1', '4'),(NULL, '3', '1')";

//$mysqli->query($queryProducts);
//$mysqli->query($queryCustomers);
//$mysqli->query($queryOrders);

//$querySelect = "SELECT FROM `orderhistory` WHERE COUNT()";

$querySelect = "SELECT customer_id, count(*)
                FROM orderhistory
                GROUP BY customer_id
";

$result_set = $mysqli->query($querySelect);

$table = [];
while(($row = $result_set->fetch_assoc()) != false){
    $table[] = $row;
}

$tableCount3 = array_filter($table,function ($v){
   return $v['count(*)'] >= 3;
});

$querySelectCustomers = "SELECT * FROM `customers` WHERE `id` IN( ";

foreach($tableCount3 as $count){
    $id = $count['customer_id'];
      $querySelectCustomers .= "$id";
    if(next($customersList)){
        $querySelectCustomers .= ',';
    }else{
        $querySelectCustomers .= ')';
    }
}

$result_set = $mysqli->query($querySelectCustomers);

$tableRes = [];
while(($row = $result_set->fetch_assoc()) != false){
    $tableRes[] = $row;
}


$mysqli->close();



















?>