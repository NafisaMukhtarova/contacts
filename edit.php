
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


$data=[':id' =>$_GET['id']]; 



$result = $pdo->prepare("SELECT * FROM `contacts` WHERE `contact_id`=:id ");
$result->execute($data);


$model_select=[];


while ($row = $result->fetch())
{
    $model_select[] = $row;
}
//var_dump($model_select);

$model = ['title'=> "Редактировать контакт",'contact'=>$model_select];
//var_dump($model);

echo $handlebars->render("edit", $model);