<?php
require_once '../config.php';
require_once '../functions.php';

$adminPassword = "admin123"; // CHANGE THIS!

if (!isset($_GET["pass"]) || $_GET["pass"] !== $adminPassword) {
    die("🔒 Unauthorized. Add ?pass=admin123");
}

$users = file_exists(USER_FILE) ? json_decode(file_get_contents(USER_FILE), true) : [];

if (isset($_POST['key'])) {
    file_put_contents("../key.txt", $_POST['key']);
    echo "🔑 Key updated!<br><br>";
}

if (isset($_POST['broadcast'])) {
    $msg = $_POST['broadcast'];
    foreach ($users as $user) {
        sendMessage($user, "📢 Broadcast:\n\n$msg");
    }
    echo "📩 Message sent to " . count($users) . " users!<br><br>";
}
?>

<h2>🛠 Admin Panel</h2>

<form method="POST">
    <h3>Update Key</h3>
    <input type="text" name="key" placeholder="New key" required><br>
    <button type="submit">Update Key</button>
</form>

<br>

<form method="POST">
    <h3>Broadcast Message</h3>
    <textarea name="broadcast" placeholder="Your message" required></textarea><br>
    <button type="submit">Send Broadcast</button>
</form>

<p><strong>Current Users:</strong> <?= count($users) ?></p>