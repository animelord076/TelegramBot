<?php
include 'Telegram.php';
include 'Database.php';
$telegram = new Telegram('7271222333:AAEMblOTR_mC4pBlNrk8jH7wksoCJ6ePt58');

$db = Database::getInstance();
$data = file_get_contents("php://input");

// مسیر فایل برای ذخیره داده‌ها  
$filePath = 'data_log.txt'; // مسیر دلخواه برای ذخیره  

// جمع‌آوری داده‌های POST و GET  
// $data = [  
//     'POST' => $_POST,  
//     'GET' => $_GET,  
//     'REQUEST' => $_REQUEST,  
//     'SERVER' => $_SERVER,  
// ];  

// ذخیره داده‌ها در فایل  
file_put_contents($filePath, print_r($data, true), FILE_APPEND);  


$text = $telegram->Text();

if($text == '/start'){
    $chat_id = $telegram->ChatID();

    $massage = "سلام به ربات مدیریت کانال و گروه خوش امدید.";
    $content = array('chat_id' => $chat_id, 'text' => $massage);
    $telegram->sendMessage($content);

    $massage = "جهت مدیریت کانال ابتدا ربات رو به کانال یا گروه اضافه کنید \n\n  سپس پیامی از کانال یا گروه که به صورت ادمین اضافه شدید رو \n\n  فروارد کنید.";
    $content = array('chat_id' => $chat_id, 'text' => $massage);
    $telegram->sendMessage($content);
}









?>
