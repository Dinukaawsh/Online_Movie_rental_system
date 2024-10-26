function editMovie(id) {
    window.location.href = `editMovie.php?id=${id}`;
}

function deleteMovie(id) {
    if (confirm("Are you sure you want to delete this movie?")) {
        // Call the PHP file to handle deletion
        window.location.href = `deleteMovie.php?id=${id}`;
    }
}
