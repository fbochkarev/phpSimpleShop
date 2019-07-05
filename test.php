<?php
include 'elems/init.php';
//if (isset($_FILES['uploadfile'])){
//// Каталог, в который мы будем принимать файл:
//    $uploaddir = './images/';
//    $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
//
//// Копируем файл из каталога для временного хранения файлов:
//    if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
//    {
//        echo "<h3>Файл успешно загружен на сервер</h3>";
//    }
//    else { echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>"; exit; }
//}
//
//
//echo '<form action="" method=post enctype=multipart/form-data>
//<input type=file name=uploadfile>
//<input type=submit value=Загрузить></form>';

$query = "SELECT * FROM products WHERE id='11'";
$result = mysqli_query($link, $query) or die($link);
$product = mysqli_fetch_assoc($result);

unlink($product['image']);