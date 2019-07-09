<?php
include 'elems/init.php';

//Зарегистрированный пользователь имеет личный кабинет, в нем он видит свою корзину,
//а также список своих покупок.
updateProductList($link);

$content = '';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $query = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $user = mysqli_fetch_assoc($result);

    $login = $user['login'];
    $birthday = $user['birthday'];
    $age = date_diff(date_create($birthday), date_create('now'))->y;
    $email = $user['email'];

    $content .= "
    <div><h4>Данные пользователя</h4>
    Ваш id: $id<br>
    Ваш логин: $login<br>
    Ваш день рождения: $birthday<br>
    Ваш возрост: $age<br>
    Ваш email: $email
    </div><br><br>";

    $content .= cartOrListOrders($link, $id);


}

include 'elems/layout.php';

function cartOrListOrders($link, $id)
{
    $content = '';

    $query = "SELECT *, users_products.id AS user_product_id, products.name AS product_name FROM users_products
              LEFT JOIN products ON users_products.product_id = products.id WHERE users_products.user_id='$id'";
    $result = mysqli_query($link, $query) or die($link);
    for ($data = []; $row[] = mysqli_fetch_assoc($result); $data = $row) ;

    $content .= "<h4>Корзина</h4>
                <table class='table table-sm'><thead><tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Купить</th>
                </tr></thead><tbody>";

    foreach ($data as $datum){
        if ($datum['status'] == 'cart'){
            $content .= "<tr>
                        <td>{$datum['name']}</td>
                        <td>{$datum['price']}</td>
                        <td>{$datum['quantity']}</td>
                        <td><form action='' method='post'>
                            <input type='hidden' name='user_product_id' value='{$datum['user_product_id']}'>
                            <input type='submit' name='btn-pressed' value='купить'>
                        </form></td>
                        </tr>";

        }
    }

    $content .="</tbody></table><br><br>";

    $content .= "<h4>Список покупок</h4>
                <table class='table table-sm'><thead><tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Время покупки</th>
                </tr></thead><tbody>";

    foreach ($data as $datum){
        if ($datum['status'] == 'sold'){
            $content .= "<tr>
                        <td>{$datum['name']}</td>
                        <td>{$datum['price']}</td>
                        <td>{$datum['quantity']}</td>
                        <td>{$datum['sold_date']}</td>
                        </tr>";

        }
    }

    $content .="</tbody></table>";

    return $content;
}

//Покупка товара
function updateProductList($link){
    if (isset($_POST['btn-pressed'])){
        $user_product_id = $_POST['user_product_id'];
        $query = "UPDATE users_products SET status = 'sold', sold_date = NOW() WHERE id='$user_product_id'";
        mysqli_query($link, $query) or die($link);
    }
}
