<?php
// Get the ID of the movie to delete
$id = $_GET['id'];

// Load the XML file
$xml = simplexml_load_file('movies.xml');

// Convert SimpleXML to DOM to manipulate it more safely
$dom = dom_import_simplexml($xml);
$xpath = new DOMXPath($dom->ownerDocument);

// Find the movie node with the matching ID
$movies = $xml->xpath("/catalog/movie[@id='$id']");

if (!empty($movies)) {
    // Get the first match (should be unique by ID)
    $movieToDelete = $movies[0];

    // Remove the movie from its parent (catalog)
    $domMovie = dom_import_simplexml($movieToDelete);
    $domMovie->parentNode->removeChild($domMovie);

    // Save the modified XML back to the file
    $xml->asXML('movies.xml');
}

// Redirect to the admin page after deletion
header("Location: admin.php");
exit(); // Always exit after a header redirect
?>

