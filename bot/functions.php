<?php

function sendMessage($chat_id, $text, $buttons = null) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
    $data = [
        "chat_id" => $chat_id,
        "text" => $text,
        "parse_mode" => "HTML"
    ];
    if ($buttons) $data["reply_markup"] = json_encode($buttons);
    file_get_contents($url . "?" . http_build_query($data));
}

function getChatMember($chat_id, $user_id) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/getChatMember";
    $data = ["chat_id" => $chat_id, "user_id" => $user_id];
    $result = file_get_contents($url . "?" . http_build_query($data));
    return json_decode($result, true)["result"];
}

function saveUser($user_id) {
    $users = file_exists(USER_FILE) ? json_decode(file_get_contents(USER_FILE), true) : [];
    if (!in_array($user_id, $users)) {
        $users[] = $user_id;
        file_put_contents(USER_FILE, json_encode($users));
    }
}

function getKey() {
    return file_exists(KEY_FILE) ? file_get_contents(KEY_FILE) : "No key set yet!";
}