<?php
include 'elems/init.php';
$message_login = '';
$message_password = '';
$message_email = '';

if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['confirm'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $date = date('Y-m-d');

//Проверяем, состоит ли логин только из латинских букв и цифр
    $check_login_composition = preg_match("#^[0-9a-zA-Z]+$#", $login);
//Проверяем длину логина, должен быть от 4 до 10 символов
    $check_login_length = preg_match("#^[0-9a-zA-Z]{4,10}$#", $login);
//Проверяем длину пароля, должен быть от 6 до 12 символов
    $check_password = preg_match("#^[0-9a-zA-Z]{6,12}$#", $password);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // преобразуем пароль в соленый хеш
//Проверяем почтового адреса
    $check_email = preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email);

    if ($check_login_composition) {
        if ($check_login_length) {
            if ($check_password) {
                if ($check_email) {
                    if (password_verify($_POST['confirm'], $password)) {
                        $query = "SELECT login FROM users";
                        $result = mysqli_query($link, $query) or die(mysqli_error($link));
                        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;

                        //Проверяем есть ли такой логин в БД
                        $check_login_db = true;
                        foreach ($data as $value) {
                            if ($value['login'] == $login) {
                                $check_login_db = false;
                            }
                        }
                        if ($check_login_db) {
                            $query = "INSERT INTO users (login, password, birthday, email, registration_date, status_id, banned)
                                  VALUES ('$login', '$password', '$birthday', '$email', NOW(), '1', 0)";
                            mysqli_query($link, $query) or die(mysqli_error($link));

                            // Пишем в сессию пометку об авторизации:
                            $_SESSION['auth'] = true;

                            $id = mysqli_insert_id($link);
                            $_SESSION['id'] = $id;
                            $_SESSION['message'] = 'Вы зарегистрировались';
                            $_SESSION['status'] = 'user';
                            header('Location: /shop/');
                        } else {
                            $message_login = 'Логин уже занят<br><br>';
                        }
                    } else {
                        $message_email = 'Проверьте корректность email-a.<br><br>';
                    }
                } else {
                    $message_password = 'Пароль и подтверждение НЕ совпадают<br><br>';
                }
            } else {
                $message_password = 'Длина пароля должна быть от 6 до 12 символов<br><br>';
            }
        } else {
            $message_login = 'Длина логина должна быть от 4 до 10 символов<br><br>';
        }
    } else {
        $message_login = 'Логин должен состоять только из латинских букв и цифр<br><br>';
    }
}

$content = "<form action=\"\" method=\"post\">
                <h3>Регистрация</h3>
                <?= $message_login; ?>
                Введите логин (от 4 до 10):<br>
                <input type=\"text\" name=\"login\"><br>
                <?= $message_password; ?>
                Введите пароль (от 6 до 12):<br>
                <input type=\"password\" name=\"password\"><br>
                Введите подтверждение пароля:<br>
                <input type=\"password\" name=\"confirm\"><br><br>
                Введите дату рождения:<br>
                <input type=\"date\" name=\"birthday\"><br><br>
                <?= $message_email; ?>
                Введите e-mail:<br>
                <input type=\"email\" name=\"email\"><br><br>
                <input type=\"submit\" value=\"отправить\">
            </form>";

include 'elems/layout.php';
?>




