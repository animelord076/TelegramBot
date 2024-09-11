<?php
include 'Telegram.php';
include 'Database.php';
$telegram = new Telegram('7271222333:AAEMblOTR_mC4pBlNrk8jH7wksoCJ6ePt58');

$db = Database::getInstance();
$data = file_get_contents("php://input");


// دریافت داده‌های JSON  
$data = file_get_contents("php://input");  

// تبدیل داده‌های JSON به آرایه PHP  
$jsonData = json_decode($data, true);  

// بررسی وجود داده‌ها  
if ($jsonData) {  
    // مسیر فایل برای ذخیره داده‌ها  
    $filePath = 'received_data.txt';  

    // تبدیل داده‌ها به فرمت متنی برای ذخیره  
    $output = "Number: " . $jsonData['number'] . "\n";  
    $output .= "Message: " . $jsonData['message'] . "\n";  
    $output .= "Received at: " . date('Y-m-d H:i:s') . "\n\n";  

    // ذخیره داده‌ها در فایل  
    file_put_contents($filePath, $output, FILE_APPEND);  

    // نمایش پیغام موفقیت  
    echo "داده‌ها با موفقیت ذخیره شدند.";  
} else {  
    // در صورت عدم وجود داده  
    echo "خطا: داده‌ای دریافت نشد.";  
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
