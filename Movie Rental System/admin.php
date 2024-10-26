<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>Movie Admin Panel</h1>
        <button id="addMovieBtn" onclick="window.location.href='addMovie.php'">Add Movie</button>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Genre</th>
                    <th>Release Year</th>
                    <th>Rating</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="movieTableBody">
                <?php
                $xml = simplexml_load_file('movies.xml') or die("Error: Cannot create object");
                foreach ($xml->movie as $movie) {
                    echo "<tr>";
                    echo "<td>" . $movie['id'] . "</td>";
                    echo "<td>" . $movie->title . "</td>";
                    echo "<td><img src='" . $movie->image . "' alt='Movie Image' class='movie-image'></td>";
                    echo "<td>" . $movie->genre . "</td>";
                    echo "<td>" . $movie->releaseYear . "</td>";
                    echo "<td>" . $movie->rating . "</td>";
                    echo "<td><button class='edit' onclick=\"editMovie('" . $movie['id'] . "')\">Edit</button></td>";
                    echo "<td><button class='delete' onclick=\"deleteMovie('" . $movie['id'] . "')\">Delete</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="background-image"></div> <!-- Fixed background image -->
    <div id="gradient-overlay"></div> <!-- Gradient overlay -->
    <div id="particles-js" style="position: absolute; width: 100%; height: 100%; z-index: -1;"></div>
    <script src="admin.js"></script>
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="#">About Us</a>
                <a href="#">Contact</a>
                <a href="#">Privacy Policy</a>
            </div>
            <p>&copy; 2024 BLASTER Movie Rental System | All rights reserved</p>
            <div class="social-media">
                <a href="#"><img src="images/facebook-icon.png" alt="Facebook"></a>
                <a href="#"><img src="images/twitter-icon.png" alt="Twitter"></a>
                <a href="#"><img src="images/instagram-icon.png" alt="Instagram"></a>
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff" // White color for particles
                },
                "shape": {
                    "type": "circle", // Particle shape
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 6, // Increased size for thickness
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff", // White lines
                    "opacity": 0.4,
                    "width": 2 // Increased line thickness
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    </script>  
</body>
</html>




