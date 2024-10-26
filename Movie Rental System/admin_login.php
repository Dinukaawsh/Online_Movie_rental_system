<?php
session_start();
ob_start();

$xml = simplexml_load_file('admin_user.xml');

foreach ($xml->user as $user) {
    if ($user->username == $_POST['username'] && password_verify($_POST['password'], $user->password)) {
        $_SESSION['user'] = (string)$user->username;
        echo "Login successful!"; // This message is checked in JavaScript
        exit();
    }
}

echo "Invalid username or password!"; // Error message if credentials are incorrect
ob_end_flush();
?>