<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "You must be logged in to rent a movie.";
    exit();
}

$xml = simplexml_load_file('users.xml');
$movies = simplexml_load_file('movies.xml');

foreach ($xml->user as $user) {
    if ($user->username == $_SESSION['user']) {
        $rental = $user->rentals->addChild('rental');
        $rental->addChild('movieId', $_POST['movieId']);
        $rental->addChild('status', 'rented');
        $user->asXML('users.xml');
        echo "Movie rented successfully!";
        exit();
    }
}
echo "Error renting movie!";
?>


