<?php

function can_upload($file)
{
	// если имя пустое, значит файл не выбран
    if($file['name'] == '')
		return 'Вы не выбрали файл.';
        
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return 'Файл слишком большой.';
        
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
    //var_dump($getMime);
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
        
	
	return true;
  }

  

require_once 'connection.php';

$config = new Config;
$pdo = $config->Connect_PDO();




$data=[];

//var_dump($_POST);

$data=[':id' =>$_POST['contact_id'],
        ':contact_name'=>$_POST['contact_name'],
        ':contact_fullname'=>$_POST['contact_fullname'],
        ':contact_info'=>$_POST['contact_info'],
        ':contact_phone_number'=>$_POST['contact_phone_number'], 
        ':contact_email'=>$_POST['contact_email']
        //':contact_photo'=>$no_photo
        ];
//определяем фотографию

if($_FILES['image']['name']!='')
{

    $check = can_upload($_FILES['image']);
    if($check===true)
    {

        $getMime = explode('.',$_FILES['image']['name']);
	    $mime = strtolower(end($getMime));
        echo 'mime '. $mime. ' ';
        $photo = $data[':id'].'.'.$mime;
        move_uploaded_file($_FILES['image']['tmp_name'],"images/".$photo);
        
        
    }
    else 
    {
        echo $check; 
        exit();
    }
    //добавляем фото в массив
    $data =array_merge($data,[':contact_photo'=>$photo]);

}

var_dump($data);
if( isset($data[':contact_photo']))
{
    echo 'update с фотографией';
    var_dump($data);
    $result = $pdo->prepare("UPDATE `contacts` SET `contact_name` = :contact_name,
                                                        `contact_fullname` = :contact_fullname, 
                                                        `contact_info` = :contact_info,  
                                                        `contact_phone_number` = :contact_phone_number, 
                                                        `contact_email` = :contact_email,
                                                        `contact_photo` = :contact_photo
                                                WHERE `contact_id`=:id");
}
else{
    echo 'update без фотографией';
    var_dump($data);
    $result = $pdo->prepare("UPDATE `contacts` SET `contact_name` = :contact_name,
                                                        `contact_fullname` = :contact_fullname, 
                                                        `contact_info` = :contact_info,  
                                                        `contact_phone_number` = :contact_phone_number, 
                                                        `contact_email` = :contact_email
                                                        
                                                WHERE `contact_id`=:id");
}                                                
$result->execute($data);


//var_dump($data[':contact_phone_number']); 
header('Location: /');