<?php
session_start();
$_SESSION['auth'] = null;
$_SESSION['message'] = 'Вы перестал быть авторизованным';
header('Location: /shop/')
?>