<?php
include 'elems/init.php';

if (!empty($_SESSION['auth']) && $_SESSION['status'] == 'admin' && !empty($_POST['id'])) {
    $id = $_POST['id'];

    deleteFile($link, $id);

    $query = "DELETE FROM products WHERE id='$id'";
    mysqli_query($link, $query) or die($link);

    header('Location: /shop/admin.php');
}

function deleteFile($link, $id){
    $query = "SELECT * FROM products WHERE id='$id'";
    $result = mysqli_query($link, $query) or die($link);
    $product = mysqli_fetch_assoc($result);

    unlink($product['image']);
}