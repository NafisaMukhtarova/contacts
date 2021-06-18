<?php

require_once ("bootstrap.php");

//список контактов для левой части экрана
$result = $pdo->query("SELECT * FROM `contacts`  ");
//var_dump($result);


$model_select=[];


while ($row = $result->fetch())
{
    $model_select[] = $row;
}

$model = ['title'=> "Контакты",'contacts'=>$model_select];

//var_dump($model);

echo $handlebars->render("main", $model);