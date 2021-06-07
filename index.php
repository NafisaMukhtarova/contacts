<?php
# With composer we can autoload the Handlebars package
require_once ("./vendor/autoload.php");

# If not using composer, you can still load it manually.
# require 'src/Handlebars/Autoloader.php';
# Handlebars\Autoloader::register();

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

# Set the partials files
$partialsDir = __DIR__."/templates";
$partialsLoader = new FilesystemLoader($partialsDir,
    [
        "extension" => "html"
    ]
);

# We'll use $handlebars throughout this the examples, assuming the will be all set this way
$handlebars = new Handlebars([
    "loader" => $partialsLoader,
    "partials_loader" => $partialsLoader
]);

require_once 'connection.php';

$config = new Config;
$pdo = $config->Connect_PDO();

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