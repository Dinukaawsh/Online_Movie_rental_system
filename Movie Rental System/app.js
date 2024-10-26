// Function to load movies from the XML file with optional search parameters
function loadMovies(searchTerm = '', searchFilter = '') {
    const xhr = new XMLHttpRequest();
    const timestamp = new Date().getTime(); // Prevent caching
    xhr.open('GET', 'movies.xml?t=' + timestamp, true);

    xhr.onload = function () {
        if (this.status === 200) {
            const xml = this.responseXML;
            if (!xml) {
                console.error('Failed to parse XML');
                return;
            }
            const movies = xml.getElementsByTagName('movie');
            let output = '';

            for (let i = 0; i < movies.length; i++) {
                const id = movies[i].getAttribute('id');
                const title = movies[i].getElementsByTagName('title')[0]?.textContent || 'No Title';
                const genre = movies[i].getElementsByTagName('genre')[0]?.textContent || 'No Genre';
                const releaseYear = movies[i].getElementsByTagName('releaseYear')[0]?.textContent || 'N/A';
                const rating = movies[i].getElementsByTagName('rating')[0]?.textContent || 'No Rating';
                const available = movies[i].getElementsByTagName('available')[0]?.textContent === 'true';
                const image = movies[i].getElementsByTagName('image')[0]?.textContent || '';

                // Apply search filter if provided
                if (searchFilter && searchTerm) {
                    if (searchFilter === 'title' && !title.toLowerCase().includes(searchTerm.toLowerCase())) {
                        continue;
                    }
                    if (searchFilter === 'genre' && !genre.toLowerCase().includes(searchTerm.toLowerCase())) {
                        continue;
                    }
                    if (searchFilter === 'releaseYear' && releaseYear !== searchTerm) {
                        continue;
                    }
                }

                // Get rental data (mock localStorage for this example)
                const rentalInfo = getRentalData(id);
                const now = new Date().getTime();
                let rentButtonHtml = '';

                // Handle different rental states
                if (rentalInfo) {
                    const rentedAt = rentalInfo.rentedAt ? new Date(rentalInfo.rentedAt).getTime() : null;
                    const startedAt = rentalInfo.startedAt ? new Date(rentalInfo.startedAt).getTime() : null;
                    const rentalStartDeadline = rentedAt + (30 * 24 * 60 * 60 * 1000); // 30 days to start
                    const rentExpirationTime = startedAt ? startedAt + (48 * 60 * 60 * 1000) : null; // 48 hours

                    if (startedAt && now < rentExpirationTime) {
                        const hoursLeft = Math.round((rentExpirationTime - now) / (60 * 60 * 1000));
                        rentButtonHtml = `<p class="unavailable">Rental active. Time left: ${hoursLeft} hours.</p>
                                          <button class="return-button" onclick="returnMovie(${id})">Return</button>`;
                    } else if (!startedAt && now < rentalStartDeadline) {
                        rentButtonHtml = `<button class="start-rent-button" onclick="startWatching(${id})">Start Watching</button>`;
                    } else if (now >= rentalStartDeadline) {
                        rentButtonHtml = `<p class="unavailable">Rental expired</p>
                                          <button class="rent-button" onclick="rentMovie(${id})">Rent again</button>`;
                    } else {
                        rentButtonHtml = `<p class="unavailable">Rental expired</p>`;
                    }
                } else {
                    rentButtonHtml = available
                        ? `<button class="rent-button" onclick="rentMovie(${id})">Rent</button>`
                        : `<p class="unavailable">Not Available</p>`;
                }

                // Output movie data
                output += `
                    <div class="movie">
                        <img src="${image}" alt="${title}">
                        <h2>${title}</h2>
                        <p class="genre">Genre: ${genre}</p>
                        <p class="year">Release Year: ${releaseYear}</p>
                        <p class="rating">Rating: ${rating}</p>
                        ${rentButtonHtml}
                    </div>
                `;
            }

            document.getElementById('movieList').innerHTML = output;

        } else {
            console.error('Failed to load XML. Status:', this.status);
        }
    };

    xhr.send();
}

// Function to trigger search based on user input
function searchMovies() {
    const searchTerm = document.getElementById('searchInput').value;
    const searchFilter = document.getElementById('searchFilter').value;
    loadMovies(searchTerm, searchFilter); // Call loadMovies with search parameters
}

// Load all movies on page load
window.onload = function () {
    loadMovies();
};

// Rental management functions
function getRentalData(movieId) {
    const rentalData = localStorage.getItem('rentalData_' + movieId);
    return rentalData ? JSON.parse(rentalData) : null;
}

function setRentalData(movieId, data) {
    localStorage.setItem('rentalData_' + movieId, JSON.stringify(data));
}

function removeRentalData(movieId) {
    localStorage.removeItem('rentalData_' + movieId);
}

function rentMovie(movieId) {
    const confirmation = confirm('You have 30 days to start watching your rental. Do you want to rent this movie?');
    if (confirmation) {
        const rentedAt = new Date().getTime(); // Timestamp when rented
        setRentalData(movieId, { rentedAt: rentedAt, startedAt: null }); // Save rental info without starting it

        alert('Movie rented successfully! You have 30 days to start watching.');
        loadMovies(); // Reload movies to update UI
    }
}

function startWatching(movieId) {
    const rentalInfo = getRentalData(movieId);

    if (rentalInfo) {
        const now = new Date().getTime();
        const rentedAt = new Date(rentalInfo.rentedAt).getTime();
        const rentalStartDeadline = rentedAt + (30 * 24 * 60 * 60 * 1000); // 30 days to start

        if (now <= rentalStartDeadline) {
            rentalInfo.startedAt = now; // Set when movie was started
            setRentalData(movieId, rentalInfo);

            alert('You have 48 hours to finish watching this movie.');
            loadMovies(); // Reload movies to update UI
        } else {
            alert('Rental period expired. You can rent the movie again.');
            removeRentalData(movieId); // Remove expired rental
            loadMovies(); // Reload movies to update UI
        }
    }
}

function returnMovie(movieId) {
    const rentalInfo = getRentalData(movieId);
    if (rentalInfo && rentalInfo.startedAt) {
        const now = new Date().getTime();
        const startTime = new Date(rentalInfo.startedAt).getTime();
        const rentExpirationTime = startTime + (48 * 60 * 60 * 1000); // 48-hour window

        if (now <= rentExpirationTime) {
            alert('Movie returned successfully!');
            // Change the button color to green after successful return
            const returnButton = document.querySelector(`button[onclick="returnMovie(${movieId})"]`);
            if (returnButton) {
                returnButton.classList.remove('return-button');
                returnButton.classList.add('returned-button');
                returnButton.textContent = "Returned"; // Update button text
            }
        } else {
            alert('Your 48-hour viewing period has expired.');
        }

        removeRentalData(movieId); // Clear rental data
        loadMovies(); // Reload movies to update UI
    }
}

