<?php
require_once ("bootstrap.php");

$data=[':id' =>$_GET['id']]; 

$result = $pdo->prepare("SELECT * FROM `contacts` WHERE `contact_id`=:id ");
$result->execute($data);


$model_select=[];


while ($row = $result->fetch()) {
    $model_select[] = $row;
}
//var_dump($model_select);

$model = ['title'=> "Редактировать контакт",'contact'=>$model_select];
//var_dump($model);

echo $handlebars->render("edit", $model);
