

function rentMovie(movieId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'rent.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('rentalMessage').innerText = this.responseText;
        loadMovies(); // Refresh movie list after rental
    };
    xhr.send(`movieId=${movieId}`);
}



// Function to rent a movie
function rentMovie(movieId) {
    const rentalInfo = {
        rentedAt: new Date().getTime(),
        startedAt: null
    };
    setRentalData(movieId, rentalInfo);
    alert('Movie rented successfully! You have 30 days to start watching.');
    loadMovies(); // Reload to update UI
}

// Function to start watching a rented movie
function startWatching(movieId) {
    const rentalInfo = getRentalData(movieId);
    if (rentalInfo) {
        rentalInfo.startedAt = new Date().getTime();
        setRentalData(movieId, rentalInfo);
        alert('You have started watching! You have 48 hours to finish the movie.');
        loadMovies(); // Reload to update UI
    }
}

// Function to return a movie
function returnMovie(movieId) {
    localStorage.removeItem('rentalData'); // Remove rental data
    alert('Movie returned successfully!');
    loadMovies(); // Reload to update UI
}

// Load movies on page load
window.onload = loadMovies;
