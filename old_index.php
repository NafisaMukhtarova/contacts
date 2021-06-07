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
$result = $pdo->query("SELECT * FROM `contacts` ");
//var_dump($result);

$model_select=[];

$first_item; //первый элемент выборки

while ($row = $result->fetch())
{
    $model_select[] = $row;
    
    if(is_null($first_item))
    $first_item = $row['contact_id']; // записываем первый элемент выборки
    
}


//выбранный элемент для правой части экрана
//var_dump($_GET);
if (is_null($_POST['list_contact_id']))
{
    $id=$first_item; //выдаем первый элемент выборки
}    
else 
    $id = $_POST['list_contact_id'];// выдаем выбранный элемент выборки
//var_dump($id);
$result_selected = $pdo->prepare("SELECT * FROM `contacts` WHERE `contact_id`= ?");
$result_selected->execute([$id]);
$model_selected=$result_selected->fetch();
//var_dump($model_selected);


//var_dump($_GET);
/*if(is_null($_GET[list_contact_index]))
{
    $model = ['title'=> "cont",'current'=>0,'contacts'=>$model_select];
}
else 
{ 
   
    
    $model = ['title'=> "Rkdjfg",'current'=>$_GET[list_contact_index],'index_current'->$index_current,'contacts'=>$model_select]; 
    //var_dump($model);
}
*/


//инициализация общего массива
$model = ['title'=> "Контакты",'selected'=>$model_selected, 'contacts'=>$model_select];
//var_dump($model);

echo $handlebars->render("main", $model);

