<?php
include 'elems/init.php';

$content = '';

//Вносим в базу новый продукт
if (isset($_POST['btn-upload'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = "images/" . $_FILES['image']['name'];
    $subcategory_id = $_POST['subcategory_id'];

    $query = "INSERT INTO products (id, name, image, price, subcategory_id) VALUES (NULL, '$name', '$image', '$price', '$subcategory_id')";
    mysqli_query($link, $query) or die($link);


    // Каталог, в который мы будем принимать файл:
    $uploaddir = './images/';
    $uploadfile = $uploaddir . basename($_FILES['image']['name']);

// Копируем файл из каталога для временного хранения файлов:
    if (copy($_FILES['image']['tmp_name'], $uploadfile)) {
        $content .= "<h3>Файл успешно загружен на сервер</h3>";
    } else {
        $content .= "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
        exit;
    }
}


if (!empty($_SESSION['auth']) && $_SESSION['status'] == 'admin') {

    $content .= insertProduct($link);

}

include 'elems/layout.php';


function insertProduct($link)
{
    $subcategory = getSubcategories($link);
    $content = '';

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = "SELECT * FROM products WHERE id='$id'";
        $result = mysqli_query($link, $query) or die($link);
        $product = mysqli_fetch_assoc($result);

        $content .= "<form action='' method='post' enctype='multipart/form-data'>
                        <h4>Редактирование продукта</h4>
                        Введите название:<input type='text' name='name' value='{$product['name']}'><br>
                        Введите цену:<input type='number' name='price' value='{$product['price']}' step='0.01'><br>
                        Выберите картинку:<br>
                        <input type='file' name='image' value='{$product['image']}'><br>
                        Выберите подкатегорию:
                        <select name='subcategory_id'>
                            {$subcategory}
                        </select><br><br>
                        <input type='submit' name='btn-upload'>
                    </form>";
    } else {
        $content .= "<form action='' method='post' enctype='multipart/form-data'>
                        <h4>Добавление нового продукта</h4>
                        Введите название:<input type='text' name='name'><br>
                        Введите цену:<input type='number' name='price' step='0.01'><br>
                        Выберите картинку:<br>
                        <input type='file' name='image'><br>
                        Выберите подкатегорию:
                        <select name='subcategory_id'>
                            {$subcategory}
                        </select><br><br>
                        <input type='submit' name='btn-upload'>
                    </form>";
    }
    return $content;
}

function getSubcategories($link)
{
    $query = "SELECT * FROM subcategory";
    $result = mysqli_query($link, $query) or die($link);
    for ($data = []; $row[] = mysqli_fetch_assoc($result); $data = $row) ;

    $subcategory = '';
    foreach ($data as $datum) {
        $subcategory .= "<option value='{$datum['id']}'>{$datum['name']}</option>";
    }

    return $subcategory;
}
