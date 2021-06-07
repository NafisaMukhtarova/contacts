<?php
//Функция проверки изображения
function can_upload($file)
{
	// если имя пустое, значит файл не выбран
    //if($file['name'] == '')
	//	return 'Вы не выбрали файл.';
        
	
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

//var_dump($_FILES['image']);
//Сохранение фото
//старый вариант
/*$photo;
if($_FILES['image']['name']!='')
{
    $check = can_upload($_FILES['image']);
    if($check===true)
    {
        move_uploaded_file($_FILES['image']['tmp_name'],"images/".$_FILES['image']['name']);
        $photo = $_FILES['image']['name'];
    }
    else 
    {
        echo $check; 
        exit();
    }
}
*/
//var_dump($photo);

//Добавление контакта
$data=[];
$photo;
$data=[
    ':contact_name'=>$_POST['contact_name'],
    ':contact_fullname'=>$_POST['contact_fullname'],
    ':contact_info'=>$_POST['contact_info'],
    ':contact_phone_number'=>$_POST['contact_phone_number'],
    ':contact_email'=>$_POST['contact_email'],
    ':contact_photo'=>$photo
    ];

    


$result = $pdo->prepare("INSERT INTO `contacts`(`contact_name`, 
                                                `contact_fullname`,
                                                `contact_info`,
                                                `contact_phone_number`,
                                                `contact_email`,
                                                `contact_photo`
                                                ) 
                                                VALUES  (:contact_name, 
                                                        :contact_fullname,  
                                                        :contact_info, 
                                                        :contact_phone_number, 
                                                        :contact_email,
                                                        :contact_photo) ");

//ВОПРОС АЙБУЛАТУ
//как проверить успешность вставки и точно вернуть последний вставленный ID?
//как работают try catch?

//  1
/* ВАРИАНТ  с try-catch
try {
    $result->execute($data);
} catch (PDOException $e) {
   if ($e->getCode() == 1062) {
       // Take some action if there is a key constraint violation, i.e. duplicate name
   } else {
       throw $e;
   }
}
echo "Success!";
*/

//2
//ВАРИАНТ lastInsertId

$result->execute($data);

if ($pdo->lastInsertId()!==null)
{
    $lastid = $pdo->lastInsertId();
    echo 'lastId '.$lastid .' ';

   if($_FILES['image']['name']!='')
    {
    $check = can_upload($_FILES['image']);
    if($check===true)
    {
        $getMime = explode('.',$_FILES['image']['name']);
	    $mime = strtolower(end($getMime));
        echo 'mime '. $mime. ' ';
        $photo = $lastid.'.'.$mime;
        move_uploaded_file($_FILES['image']['tmp_name'],"images/".$photo);
        
        echo 'photo '. $photo. ' ';
        $update_result = $pdo->prepare("UPDATE `contacts` SET `contact_photo` = :photo WHERE `contact_id`= :id ");
        $update_result->execute([':id'=>$lastid,':photo'=>$photo]);
    }
    else 
    {
        echo $check; 
        exit();
    }


}

}

//3
//ВАРИАНТ 
/*
$ Stmt-> rowCount ()
*/ 

//вставляем фото


//print_r($_FILES['image']);

//header('Location: /');