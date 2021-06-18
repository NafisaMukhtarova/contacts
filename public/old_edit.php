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


//var_dump($_GET);

if(isset($_POST['button_delete']))
{
    $model = [  'title'=>"Удалить контакт",
                'button'=>"sql_delete",
                'button_name'=>"Удалить",
                'contact_name'=>  $_POST[selected_contact_name],
                'contact_fullname'=>  $_POST[selected_contact_fullname],
                'contact_info'=>  $_POST[selected_contact_info],
                'contact_phone_number'=>  $_POST[selected_contact_phone_number],
                'contact_email'=>  $_POST[selected_contact_email],
                'contact_id'=>  $_POST[selected_contact_id]
                
            ];
    
}
elseif(isset($_POST['button_edit']))
{ 
    $model = [  'title'=>"Редактировать контакт",
                'button'=>"sql_update",
                'button_name'=>"Редактировать",
                'contact_name'=>  $_POST[selected_contact_name],
                'contact_fullname'=>  $_POST[selected_contact_fullname],
                'contact_info'=>  $_POST[selected_contact_info],
                'contact_phone_number'=>  $_POST[selected_contact_phone_number],
                'contact_email'=>  $_POST[selected_contact_email],
                'contact_id'=>  $_POST[selected_contact_id]
    
    ];
}
elseif(isset($_POST['button_add']))
{
    $model = [  'title'=>"Добавить контакта",
                'button'=>"sql_insert",
                'button_name'=>"Добавить"
            ];
}

    
    

echo $handlebars->render("edit", $model);

//header('Location: /');

