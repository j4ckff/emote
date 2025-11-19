<?php
require_once 'config.php';
require_once 'functions.php';

$data = json_decode(file_get_contents('php://input'), true);
$chat_id = $data['message']['chat']['id'];
$text = $data['message']['text'];
$user_id = $data['message']['from']['id'];

if ($text == "/start") {
    $member = getChatMember(CHANNEL_USERNAME, $user_id);
    if ($member && $member["status"] != "left" && $member["status"] != "kicked") {
        saveUser($user_id);
        sendMessage($chat_id, "🎉 Welcome to the bot! Use the buttons below:", [
            "keyboard" => [
                [["text" => "🔑 Get Key"]],
                [["text" => "📢 Subscribe YouTube"], ["text" => "📸 Follow Instagram"]]
            ],
            "resize_keyboard" => true
        ]);
    } else {
        sendMessage($chat_id, "❌ You didn't join our channel.\n\n📢 Please join first: " . CHANNEL_USERNAME);
    }
}

elseif ($text == "🔑 Get Key") {
    sendMessage($chat_id, "🔑 Your Key Is: " . getKey());
}

elseif ($text == "📢 Subscribe YouTube") {
    sendMessage($chat_id, "▶️ YouTube: https://youtube.com/@j4ckffx");
}

elseif ($text == "📸 Follow Instagram") {
    sendMessage($chat_id, "📸 Instagram: https://www.instagram.com/j4ckffx");
}

elseif ($user_id == ADMIN_ID && $text == "/admin") {
    sendMessage($chat_id, "🛠 Admin Panel: https://battlearena.fun/bot/admin/panel.php?pass=admin123");
}

else {
    sendMessage($chat_id, "💬 Send /start to begin:");
}