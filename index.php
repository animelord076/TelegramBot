<?php
include 'Telegram.php';
include 'Database.php';
$telegram = new Telegram('7271222333:AAEMblOTR_mC4pBlNrk8jH7wksoCJ6ePt58');

$db = Database::getInstance();
$data = file_get_contents("php://input");


// مسیر فایل برای ذخیره داده‌ها  
$filePath = 'public_html/data_log.txt'; // مسیر دلخواه برای ذخیره  

// بررسی وجود فایل و ایجاد آن در صورت عدم وجود  
if (!file_exists($filePath)) {  
    // ایجاد فایل جدید  
    $handle = fopen($filePath, 'w');  
    if ($handle === false) {  
        die("خطا در ایجاد فایل.");  
    }  
    fclose($handle);  
}  

// جمع‌آوری داده‌های POST و GET  
$data = [  
    'POST' => $_POST,  
    'GET' => $_GET,  
    'REQUEST' => $_REQUEST,  
    'SERVER' => $_SERVER,  
];  

// ذخیره داده‌ها در فایل و جلوگیری از خطا  
if (file_put_contents($filePath, print_r($data, true), FILE_APPEND) === false) {  
    die("خطا در ذخیره داده‌ها.");  
}  


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
