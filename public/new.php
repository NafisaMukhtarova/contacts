
<?php
require_once ("bootstrap.php");

$model = ['title'=> "Новый контакт"];
//var_dump($model);

echo $handlebars->render("new", $model);