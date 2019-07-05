<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'eshop';

$link = mysqli_connect($host, $user, $password, $dbname);
mysqli_query($link, "SET NAMES 'utf8'");
