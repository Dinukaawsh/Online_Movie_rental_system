<?php
$id = $_GET['id'];
$xml = simplexml_load_file('movies.xml');
$movie = $xml->xpath("//movie[@id='$id']")[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie->title = $_POST['title'];
    $movie->genre = $_POST['genre'];
    $movie->releaseYear = $_POST['releaseYear'];
    $movie->rating = $_POST['rating'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $imageName);
        $movie->image = "uploads/" . $imageName;
    }

    $xml->asXML('movies.xml');
    // Redirect to the admin panel after saving
    header("Location: admin.php");
    exit(); // Stop further execution after redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif; /* Sleek, modern font */
    margin: 0;
    padding: 0;
    display: flex; /* Flexbox centering */
    flex-direction: column; /* Column direction for main and footer */
    justify-content: space-between; /* Space between header and footer */
    height: 100vh; /* Full viewport height */
    overflow-y: auto;
    background: 
        url('images/cinema.jpg') no-repeat center center fixed;
   
    background-size: cover; /* Makes the image cover the entire background */
    background-position: center; /* Centers the image */
    background-repeat: no-repeat;
    animation: gradientAnimation 10s ease-in-out infinite; /* Faster animation */
        }

        /* Container for the form */
        .container {
            width: 100%;
    max-width: 500px; /* Increased max-width for more content space */
    margin: 20px auto; /* Added margin for top spacing */
    padding: 40px 50px; /* Increased padding for breathing space */
    background-color: rgba(255, 255, 255, 0.1); /* Transparent white background */
    border-radius: 25px; /* Increased rounded corners */
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3); /* Deeper shadow for more depth */
    backdrop-filter: blur(12px); /* Enhanced blur effect for a frosted look */
    text-align: center;
        }

        h1 {
            text-align: center; /* Center the header */
            color: white; 
            margin-bottom: 20px; /* Spacing below header */
        }

        /* Input Fields */
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%; /* Full width for inputs */
            padding: 12px; /* Padding inside the inputs */
            margin: 15px 0; /* Spacing between inputs */
            border: 1px solid #ced4da; /* Border styling */
            border-radius: 10px; /* More rounded corners */
            font-size: 16px; /* Font size */
            background-color: #f8f9fa; /* Light background for inputs */
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #74ebd5; /* Change border color on focus to match gradient */
            outline: none; /* Remove default outline */
        }

        /* Image Styling */
        .movie-image {
            width: 100px; /* Size for the image */
            height: auto; /* Maintain aspect ratio */
            margin: 10px 0; /* Spacing around the image */
            border-radius: 10px; /* Rounded corners for the image */
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

         /* Button Container */
         .button-container {
            display: flex;
            justify-content: center;
            gap: 20px; /* Space between buttons */
        }

        /* Button Styles */
        .button {
            padding: 10px 30px; /* Adjusted padding */
            border-radius: 50px; /* Fully rounded buttons */
            text-decoration: none;
            overflow: hidden; /* Hide overflow for ripple effect */
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff; /* White text color */
            background-color: #6f35dc; /* Transparent background */
            border: 2px solid transparent; /* Initially no border */
            position: relative;
            z-index: 1;
            transition: all 0.4s ease; /* Smooth transition for hover effects */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
        }

        /* Before Hover Effect */
        .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: linear-gradient(45deg, #ff0095, #6f35dc); /* Gradient hover color */
            z-index: -1;
            border-radius: 50px; /* Match the button's rounded shape */
            transition: all 0.5s ease; /* Smooth transition for hover effect */
        }

        /* On Hover */
        .button:hover::before {
            width: 100%; /* Expand background to full width */
        }

        .button:hover {
            color: #fff; /* Keep the text white */
            transform: translateY(-5px); /* Slight lift on hover */
            border: 2px solid #fff; /* White border on hover */
            background-color: #e91e63; /* Darker shade on hover */
        }
        button:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            border-radius: 50%;
            animation: ripple 0.6s linear;
            opacity: 0;
        }
        
        button:active:after {
            transform: scale(4); /* Scale up the ripple */
            opacity: 1; /* Make it visible */
        }

        /* Active/Pressed Effects */
        .button:active {
            transform: translateY(2px); /* Push down slightly on click */
            box-shadow: none; /* Remove shadow on click */
            transform: scale(0.98); /* Slightly reduce size on click */
        }
        .button:focus {
            outline: 2px solid #ff0095; /* Highlight focus state */
            outline-offset: 2px; /* Space the outline away from the button */
        }
        @keyframes ripple {
            from {
                transform: scale(0);
                opacity: 0.5;
            }
            to {
                transform: scale(4);
                opacity: 0;
            }
        }


        /* Footer */
 footer {
    background-color: rgba(0, 0, 0, 0.6); /* Transparent footer */
    color: #fff;
    padding: 10px 0; /* Reduced padding for footer */
    text-align: center;
}

.footer-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.footer-links {
    margin-bottom: 5px;
}

.footer-links a {
    color: #fff;
    margin: 0 15px;
    text-decoration: none;
}

.footer-links a:hover {
    color: #f0db4f;
}

footer p {
    margin: 5px 0;
}

.social-media a {
    margin: 0 10px;
}

.social-media a img {
    width: 24px;
    height: 24px;
}

.social-media a:hover img {

    opacity: 0.8;
}
.footer-links a {
    padding: 0 8px; /* Adds more clickable space */
}


/* Fade In Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 600px) {
    main {
        padding: 20px 10px; /* Reduced padding for mobile */
    }

    .button-container {
        flex-direction: column;
    }

    .button-container .btn {
        width: 100%; /* Full-width buttons on mobile */
        margin-bottom: 10px; /* Space between buttons */
    }
}
/* Overlay with Animated Gradient */
#gradient-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* In front of the background image */
    background: linear-gradient(45deg, rgba(255, 0, 149, 0.2), rgba(255, 111, 53, 0.2), rgba(111, 53, 220, 0.2)); /* Reduced opacity */
    animation: gradientAnimation 10s ease-in-out infinite; /* Gradient animation */
    backdrop-filter: blur(5px); /* Reduced blur effect */
}

        /* Keyframes for animated gradient overlay */
        @keyframes gradientAnimation {
            0% {
                opacity: 1; /* Start fully opaque */
            }
            25% {
                opacity: 0.8; /* Slightly transparent */
            }
            50% {
                opacity: 1; /* Fully opaque again */
            }
            75% {
                opacity: 0.8; /* Slightly transparent */
            }
            100% {
                opacity: 1; /* Back to fully opaque */
            }
        }

        /* Enhanced Particle Background */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 1.5; /* Slightly more transparent */
        }

    </style>
</head>
<body>
<div id="background-image"></div> <!-- Fixed background image -->
    <div id="gradient-overlay"></div> <!-- Gradient overlay -->
    <div id="particles-js" style="position: absolute; width: 100%; height: 100%; z-index: -1;"></div>
    <div class="container">
        <h1>Edit Movie</h1>
        <form action="editMovie.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" value="<?php echo $movie->title; ?>" required>
            <input type="text" name="genre" value="<?php echo $movie->genre; ?>" required>
            <input type="number" name="releaseYear" value="<?php echo $movie->releaseYear; ?>" required>
            <input type="number" step="0.1" name="rating" value="<?php echo $movie->rating; ?>" required>
            <input type="file" name="image" accept="image/*">
            <img src="<?php echo $movie->image; ?>" alt="Current Image" class="movie-image">
            <div class="button-container">
            <button class="button" type="submit">Update Movie</button>
            </div>
        </form>
    </div>
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