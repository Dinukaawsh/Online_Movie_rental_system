<?php
// Load the users.xml file into DOMDocument
$xml = new DOMDocument('1.0', 'UTF-8');
$xml->preserveWhiteSpace = false; // To remove excess whitespace
$xml->formatOutput = true; // Enables pretty printing

// Load the existing XML content into DOMDocument
$xml->load('users.xml');

// Get the root element (users)
$root = $xml->getElementsByTagName('users')->item(0);

// Create new user element
$newUser = $xml->createElement('user');

// Add the 'id' element (auto-incremented)
$id = $xml->createElement('id', $root->getElementsByTagName('user')->length + 1);
$newUser->appendChild($id);

// Add the 'username' element
$username = $xml->createElement('username', $_POST['username']);
$newUser->appendChild($username);

// Add the 'password' element (hashed)
$password = $xml->createElement('password', password_hash($_POST['password'], PASSWORD_DEFAULT));
$newUser->appendChild($password);

// Add the 'rentals' element (empty initially)
$rentals = $xml->createElement('rentals');
$newUser->appendChild($rentals);

// Append the new user element to the root
$root->appendChild($newUser);

// Save the updated XML to the file, with proper formatting
$xml->save('users.xml');

echo "User registered successfully!";
?>

