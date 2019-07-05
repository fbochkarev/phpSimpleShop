<?php
include 'elems/init.php';

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
    <div>
    Ваш id: $id<br>
    Ваш логин: $login<br>
    Ваш день рождения: $birthday<br>
    Ваш возрост: $age<br>
    Ваш email: $email
    </div>";
}

include 'elems/layout.php';
