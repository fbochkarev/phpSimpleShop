<?php
include 'elems/init.php';

$form = '<form action="" method="post">
            <h3>Авторизация</h3>
            Введите логин:<br>
            <input type="text" name="login"><br>
            Введите пароль:<br>
            <input type="password" name="password"><br><br>
            <input type="submit">
        </form>';

$content = '';

if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];

    $query = "SELECT *, users.id as userId, statuses.name AS status FROM users 
              LEFT JOIN statuses ON users.status_id = statuses.id WHERE login='$login'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $user = mysqli_fetch_assoc($result);


    if (!empty($user)) {
        // Пользователь с таким логином есть, теперь надо проверять пароль.

        $hash = $user['password'];// солёный пароль из базы

        if (password_verify($_POST['password'], $hash)) {
            if ($user['banned'] != 1) {
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $user['userId'];
                $_SESSION['status'] = $user['status'];
                header('Location: /shop/index.php');
            } else {
                echo "you was banned<br><br>";
                echo $form;
            }
        } else {
            $content .= "incorrect login or password<br><br>";
            $content .= $form;
        }
    } else {
        $content .= $form;
    }
} else {
    $content .= $form;
}

include 'elems/layout.php';