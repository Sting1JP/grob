<?php


require_once "/var/www/html/blocks/session.php";


if (!isset($login_session) || !isset($_POST['score'])) {
    http_response_code(400);
    echo "Missing session or score.";
    exit;
}

$username = $login_session;
$newScore = (int)$_POST['score'];

$xmlFile = 'scores.xml';

// Load or create XML
if (!file_exists($xmlFile)) {
    $xml = new SimpleXMLElement('<scores></scores>');
} else {
    $xml = simplexml_load_file($xmlFile);
}

// Check if user exists
$found = false;
foreach ($xml->user as $user) {
    if ((string)$user['name'] === $username) {
        $found = true;
        $existingScore = (int)$user;
        if ($newScore > $existingScore) {
            $user[0] = $newScore;
        }
        break;
    }
}

// Add new user if not found
if (!$found) {
    $user = $xml->addChild('user', $newScore);
    $user->addAttribute('name', $username);
}

// Save updated XML
$xml->asXML($xmlFile);
echo "Score updated.";
?>
