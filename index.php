<?php

include 'Telegram.php';
include 'Database.php';

$telegram = new Telegram('7271222333:AAEMblOTR_mC4pBlNrk8jH7wksoCJ6ePt58');

$db = Database::getInstance();


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
