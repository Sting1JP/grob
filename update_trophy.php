<?php

require_once "/var/www/html/blocks/session.php";

if (!isset($login_session) || !isset($_POST['trophy_name']) || !isset($_POST['description'])) {
    http_response_code(400);
    echo "Missing session or trophy data.";
    exit;
}

$username = $login_session;
$trophyName = trim($_POST['trophy_name']);
$description = trim($_POST['description']);

$xmlFile = 'trophies.xml';

// Load or create XML
if (!file_exists($xmlFile)) {
    $xml = new SimpleXMLElement('<trophies></trophies>');
} else {
    $xml = simplexml_load_file($xmlFile);
}

// Search for existing trophy
$trophy = null;
foreach ($xml->trophy as $t) {
    if ((string)$t['name'] === $trophyName) {
        $trophy = $t;
        break;
    }
}

// If trophy doesn't exist, create it
if (!$trophy) {
    $trophy = $xml->addChild('trophy');
    $trophy->addAttribute('name', $trophyName);
    $trophy->addChild('description', $description);
    $trophy->addChild('users');
}

// Check if user already unlocked it
$userList = $trophy->users;
$alreadyUnlocked = false;
foreach ($userList->user as $user) {
    if ((string)$user === $username) {
        $alreadyUnlocked = true;
        break;
    }
}

// Add user to unlocked list
if (!$alreadyUnlocked) {
    $userList->addChild('user', $username);
}

// Save XML
$xml->asXML($xmlFile);
echo "Trophy updated.";

?>
