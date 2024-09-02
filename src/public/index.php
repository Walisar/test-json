<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<form method="post">
    <input type="submit" name="test" id="test" value="Запросить json и сохранить в БД" /><br/>
</form>

</html>
<?php

/*$sql = "CREATE TABLE products  (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
id_prod VARCHAR(6) NOT NULL,
title VARCHAR(100) NOT NULL,
description VARCHAR(300) NOT NULL,
category VARCHAR(300) NOT NULL
)";
*/


function testFun()
{   $db_host = 'mysql';
    $db_user = 'user1';
    $db_password = 's123';
    $db_name = 'test';

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }



    $url = 'https://dummyjson.com/products/search?q=Iphone';
    $res = file_get_contents($url);



    $arr = json_decode($res, true);

    $query = '';
    $table_data = '';


    foreach ($arr['products'] as $product) {

        $descriptionProd = mysqli_real_escape_string($conn, $product['description']);

        $query .= "INSERT INTO `products` (`id_prod`, `title`, `description`, `category`) VALUES 
        ('" . $product["id"] . "',
         '" . $product["title"] . "',
        '" .$descriptionProd. "',
        '" . $product["category"] . "');";
        echo '<br>';


        $table_data .= '
                <tr>
                    <td>' . $product["id"] . '</td>
                    <td>' . $product["title"] . '</td>
                    <td>' . $product["description"] . '</td>
                    <td>' . $product["category"] . '</td>
                </tr>
                ';


    }


    if (mysqli_multi_query($conn, $query)) {
        echo '<h3>Inserted JSON Data</h3><br />';
        echo '
                <table class="table table-bordered">
                <tr>
                    <th width="45%">id</th>
                    <th width="10%">title</th>
                    <th width="45%">description</th>
                    <th width="45%">category</th>
                </tr>
                ';
        echo $table_data;
        echo '</table>';
    }
    
}


if(array_key_exists('test',$_POST)){
    testFun(); }