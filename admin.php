<?php
include 'elems/init.php';

$content = '';

if (!empty($_SESSION['auth']) && $_SESSION['status'] == 'admin') {

    $content .= getUsers($link);

    $content .= getProducts($link);

    $content .= "<h4>Новый продукт:</h4>
                <form action='add.php'>
                <input type='submit' value='+ Добавить'>
                </form>";

}

include 'elems/layout.php';

//Функция для вывода списка продуктов
function getProducts($link)
{
    $query = "SELECT *, products.id as id, products.name AS name, category.name as category, subcategory.name AS subcategory FROM products
                LEFT JOIN subcategory ON products.subcategory_id=subcategory.id
                LEFT JOIN category ON subcategory.category_id=category.id";


    $result = mysqli_query($link, $query) or die($link);
    for ($data = []; $row[] = mysqli_fetch_assoc($result); $data = $row) ;

    $products = "<h4>Продукты:</h4>
                <table class='table table-sm'><thead>
                        <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>price</th>
                        <th>category</th>
                        <th>subcategory</th>
                        <th>edit</th>
                        <th>delete</th>
                        </tr>
                        </thead>
                        <tbody>";

    foreach ($data as $datum) {
        $products .= "<tr><td>{$datum['id']}</td>
                        <td>{$datum['name']}</td>
                        <td>{$datum['price']}</td>
                        <td>{$datum['category']}</td>
                        <td>{$datum['subcategory']}</td>
                        <td></td>
                        <td><form action='deleteProduct.php' method='post'>
                            <input type='hidden' name='id' value='{$datum['id']}'>
                            <input type='submit' value='удалить'>
                        </form></td>
                        </tr>";
    }


    $products .= "</tbody></table><br><br><br>";

    return $products;
}

function getUsers($link)
{
    $query = 'SELECT users.id, login, banned, statuses.name AS status FROM users 
    LEFT JOIN statuses ON users.status_id = statuses.id';
    $result = mysqli_query($link, $query) or die($link);

    for ($data = []; $row[] = mysqli_fetch_assoc($result); $data = $row) ;

    $content = '<h4>Пользователи:</h4>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>login</th>
                            <th>status</th>
                            <th>delete</th>
                            <th>status</th>
                            <th>banned</th>
                            <th>banStatus</th>
                        </tr>
                    </thead>
                    <tbody>';
    foreach ($data as $datum) {
        $color = '';
        if ($datum['status'] == 'admin') {
            $color = 'red';
        } else {
            $color = 'green';
        }

        $banned = '';
        $banStatus = '';
        if ($datum['banned'] == 1) {
            $banned = 'разбанить';
            $banStatus = 'забанен';
        } else {
            $banned = 'забанить';
            $banStatus = 'не забанен';
        }

        $content .= "<tr style='color: {$color}'>
                        <td>{$datum['id']}</td>
                        <td>{$datum['login']}</td>
                        <td>{$datum['status']}</td>
                        <td><form action='deleteAdmin.php' method='post'>
                            <input type='hidden' name='id' value='{$datum['id']}'>
                            <input type='submit' value='удалить'>
                        </form></td>
                        <td><form action='changeStatus.php' method='post'>
                            <input type='hidden' name='id' value='{$datum['id']}'>
                            <input type='hidden' name='status' value='{$datum['status']}'>
                            <input type='submit' value='изменить'>
                        </form></td>
                        <td>{$banStatus}</td>
                        <td><form action='banned.php' method='post'>
                            <input type='hidden' name='id' value='{$datum['id']}'>
                            <input type='hidden' name='banned' value='{$datum['banned']}'>
                            <input type='submit' value='$banned'>
                        </form></td>
                    </tr>";
    }

    $content .= "</tbody></table><br><br><br>";

    return $content;
}