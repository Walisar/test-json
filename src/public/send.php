<?php
$data = ["title" => $_POST["title"], "description" => $_POST["descr"]];
$data_string = json_encode ($data, JSON_UNESCAPED_UNICODE);
$curl = curl_init('https://dummyjson.com/products/add');
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
// Принимаем в виде массива. (false - в виде объекта)
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
]);
$result = curl_exec($curl);
curl_close($curl);

echo '<pre>';
var_dump($result);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>send json</title>

<h1> Форма для отправки JSON </h1>

<form action="send.php" method="post">
    <p>
        <input type="text" id="title" name="title" placeholder="title">
        <input type="text" id="descr" name="descr" placeholder="description">

        <button class="form_auth_button" type="submit" name="form_auth_submit">Отправить json</button>

    <p class="result" style="color:blue"> <?php if ($result) {echo  "Сервер получил следющие данные: название продукта " . $_POST['title'] . ' ' . "и описание " . $_POST['descr'];} ?> </p>
    </p>
</form>

</html>




