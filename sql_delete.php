<?php


require_once 'connection.php';

$config = new Config;
$pdo = $config->Connect_PDO();


//var_dump($result);


//print $_GET['id'];

$data=[':id' =>$_GET['id']]; //id записи
$photo = $_GET['photo']; // имя файла - фото

//Фото к удалению

$dir = 'images/';
var_dump($dir.$photo);

//Запись к удалению
$result = $pdo->prepare("DELETE FROM `contacts`WHERE `contact_id`=:id ");

if($result->execute($data))
{
    unlink($dir.$photo);
}




    header('Location: /'); 