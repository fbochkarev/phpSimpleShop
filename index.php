<?php
include 'elems/init.php';

$title = 'Главная';
/**
Реализуйте интернет магазин. В нем должны быть товары, категории, подкатегории. Список категорий и подкатегорий должен
размещаться в сайдбаре сайта. У каждого товара должна быть цена, картинка, кнопка 'в корзину'.

Реализуйте регистрацию пользователей. Зарегистрированный пользователь имеет личный кабинет, в нем он видит свою корзину,
а также список своих покупок.

Реализуйте админку, в которой можно добавлять, удалять и редактировать товары. Также в админке виден список пользователей.
Админ может забанить и разбанить пользователя, а также повысить его до админа. Также в админке должна быть статистика покупок - сумма продаж по месяцам.
 */
$content = '';

//Добавляе в корзину если что есть
add2cart($link);

//Выводим товары
$content .= showProduct($link);

include 'elems/layout.php';

function add2cart($link){
    if (isset($_SESSION['auth']) && isset($_POST['btn-pressed'])){
        $user_id = $_SESSION['id'];
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];


        $query = "INSERT INTO users_products (user_id, product_id, quantity, status) VALUES 
                  ('$user_id', '$product_id', '$quantity', 'cart')";
        mysqli_query($link, $query) or die($link);
    }
}

function showProduct($link){
    $query = "SELECT * FROM products";
    $result = mysqli_query($link, $query) or die($link);
    for ($data = []; $row[] = mysqli_fetch_assoc($result); $data = $row);

    $content = '<table><tbody><tr>';

    foreach ($data as $product) {
        $content .= "<td><div>
                    <form action='' method='post'>
                        <input type='hidden' name='product_id' value='{$product['id']}'>
                        <h4>{$product['name']}</h4>
                        <img src='{$product['image']}' width='189' height='255' alt='{$product['name']}'><br>
                        price: {$product['price']}<br>
                        quantity:<input style='width: 40px' type='number' name='quantity'><br>
                    <input type='submit' value='в корзину' name='btn-pressed'>
                    </form>
                </div></td>";
    }

    $content .= '</tr></tbody></table>';

    return $content;
}