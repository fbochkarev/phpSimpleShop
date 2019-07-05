<?php

if (!empty($_SESSION['auth'])) {
    $id = $_SESSION['id'];

    $query = "SELECT *, statuses.name AS status FROM users 
              LEFT JOIN statuses ON users.status_id=statuses.id WHERE users.id='$id'";
    $result = mysqli_query($link, $query) or die($link);
    $user = mysqli_fetch_assoc($result);

    echo 'login: ' . $user['login'] . '<br>status: ' . $_SESSION['status'] . '<br><br>';

    echo '<a href="/shop/logout.php">выход</a><br>';

    echo '<a href="/shop/index.php">главная  </a>';
    if ($_SESSION['status'] == 'admin') {
        echo '<a href="/shop/admin.php">админка  </a>';
    }
    echo '<a href="/shop/profile.php">профиль</a>';

} else {
    echo '<a href="/shop/login.php">вход</a> или <a href="/shop/register.php">регистрация</a><br>';
    echo '<a href="/shop/index.php">главная</a>';
}
echo '<br><br>';

echo getCategory($link);

function getCategory($link)
{
    $query = "SELECT * FROM category";
    $result = mysqli_query($link, $query) or die($link);
    for ($data = []; $row[] = mysqli_fetch_assoc($result); $data = $row) ;

    $categories = '';
    foreach ($data as $datum) {
        $categories .= "<a href='../index.php?category_id={$datum['id']}'>{$datum['name']}</a>";
    }

    return $categories;
}