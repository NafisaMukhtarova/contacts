<?php

require_once 'connection.php';

$config = new Config;
$pdo = $config->Connect_PDO();


$data=[];
//var_dump($_POST);
if(isset($_POST['sql_update'])) //Изменить данные контакта
{
$data=[':id' =>$_POST[contact_id],
        ':contact_name'=>$_POST[contact_name],
        ':contact_fullname'=>$_POST[contact_fullname],
        ':contact_info'=>$_POST[contact_info],
        ':contact_phone_number'=>$_POST[contact_phone_number], 
        ':contact_email'=>$_POST[contact_email],
        ];
       

    $result = $pdo->prepare("UPDATE `contacts` SET `contact_name` = :contact_name,
                                                     `contact_fullname` = :contact_fullname, 
                                                     `contact_info` = :contact_info,  
                                                     `contact_phone_number` = :contact_phone_number, 
                                                     `contact_email` = :contact_email 
                                                     WHERE `contact_id`=:id");
    $result->execute($data);
//var_dump($data[':contact_phone_number']); 
    header('Location: /');
}
elseif(isset($_POST['sql_insert'])) // Добавить новый контакт
{
    //var_dump($_POST);
    //var_dump($_FILES);
    $data=[
        ':contact_name'=>$_POST[contact_name],
        ':contact_fullname'=>$_POST[contact_fullname],
        ':contact_info'=>$_POST[contact_info],
        ':contact_phone_number'=>$_POST[contact_phone_number],
        ':contact_email'=>$_POST[contact_email]
        ];

    $result = $pdo->prepare("INSERT INTO `contacts`(`contact_name`, 
                                                    `contact_fullname`,
                                                    `contact_info`,
                                                    `contact_phone_number`,
                                                    `contact_email`) 
                                                    VALUES  (:contact_name, 
                                                            :contact_fullname,  
                                                            :contact_info, 
                                                            :contact_phone_number, 
                                                            :contact_email) ");
    $result->execute($data);

    header('Location: /');
}
elseif (isset($_POST['sql_delete']))//Удаляем контакт

{
    $data=[':id' =>$_POST[contact_id]]; 
    $result = $pdo->prepare("DELETE FROM `contacts`WHERE `contact_id`=:id ");
    $result->execute($data);

    header('Location: /'); 
}
else
{
    header('Location: /'); 
}

//var_dump($data);