<?php
include 'elems/init.php';

if (!empty($_SESSION['auth']) && $_SESSION['status'] == 'admin' && !empty($_POST['id'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM users WHERE id='$id'";
    mysqli_query($link, $query) or die($link);

    header('Location: /shop/admin.php');
}