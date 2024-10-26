// auth.js
// Registration form submission handling
document.getElementById('registrationForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'register.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('registrationMessage').innerText = this.responseText;
    };
    xhr.send(`username=${username}&password=${password}`);
});

// Login form submission handling
document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'login.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        // Check if login was successful
        if (this.responseText === "Login successful!") {
            window.location.href = 'movies.html'; // Redirect to index.html
        } else {
            document.getElementById('loginMessage').innerText = this.responseText; // Show error message
        }
    };
    xhr.send(`username=${username}&password=${password}`);
});

