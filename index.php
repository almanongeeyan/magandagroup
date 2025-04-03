<?php
session_start();
include 'tresspass/connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if(isset($page_title)){echo "$page_title";}
        ?>
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    .shop-reviews {
        padding: 40px 20px;
        background-color: #f8f8f8;
        text-align: center;
    }

    .review-title {
        font-size: 2.5em;
        color: #333;
        margin-bottom: 30px;
    }

    .carousel {
        overflow: hidden;
        width: 90%;
        max-width: 900px;
        margin: 0 auto;
    }

    .carousel-inner {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .review-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 30px;
        margin: 10px;
        width: 100%;
        /* Each card takes full width in the flex container */
        box-sizing: border-box;
        text-align: left;
    }

    .review-text {
        font-size: 1.1em;
        color: #555;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .review-author {
        font-size: 1em;
        color: #777;
        font-style: italic;
        text-align: right;
    }

    /* Basic carousel navigation (you can enhance this with JavaScript) */
    .carousel-navigation {
        margin-top: 20px;
    }

    .carousel-navigation button {
        background: none;
        border: none;
        font-size: 1.5em;
        color: #007bff;
        cursor: pointer;
        margin: 0 10px;
    }

    .carousel-navigation button:hover {
        color: #0056b3;
    }
    </style>

</head>

<body>


    <div id="dogRabiesModal" class="modal">
        <div class="modal-content" style="text-align: left;">
            <span class="close" onclick="closeDogRabiesModal()">&times;</span>
            <h2><i class="fa-solid fa-dog"></i> Dog Rabies Information</h2>

            <h3 style="margin-left: 0;">What is Rabies?</h3>
            <p>Rabies is a viral disease that causes inflammation of the brain in mammals, including dogs. It is
                primarily transmitted through the bite of an infected animal.</p>

            <h3 style="margin-left: 0;">Symptoms in Dogs:</h3>
            <ul style="padding-left: 20px;">
                <li>Behavioral changes (aggression, excessive drooling)</li>
                <li>Difficulty swallowing and paralysis</li>
                <li>Fear of water (hydrophobia)</li>
                <li>Seizures</li>
            </ul>

            <h3 style="margin-left: 0;">Prevention:</h3>
            <p>Vaccination is the most effective way to prevent rabies in dogs. It is important to keep your dog’s
                rabies vaccine up to date. Avoid contact with wild animals and stray dogs, as they may carry the virus.
            </p>

            <h3 style="margin-left: 0;">What to Do if You Suspect Rabies:</h3>
            <ul style="padding-left: 20px;">
                <li>Contact a veterinarian immediately</li>
                <li>Keep the dog isolated from other animals</li>
                <li>Seek medical attention for any bites or exposures to saliva from an infected dog</li>
            </ul>
        </div>
    </div>

    <div id="catRabiesModal" class="modal">
        <div class="modal-content" style="text-align: left;">
            <span class="close" onclick="closeCatRabiesModal()">&times;</span>
            <h2><i class="fa-solid fa-cat"></i> Cat Rabies Information</h2>

            <h3 style="margin-left: 0;">What is Rabies?</h3>
            <p>Rabies is a viral disease that causes inflammation of the brain in mammals, including cats. It is
                primarily transmitted through the bite of an infected animal.</p>

            <h3 style="margin-left: 0;">Symptoms in Cats:</h3>
            <ul style="padding-left: 20px;">
                <li>Behavioral changes (aggression, excessive drooling)</li>
                <li>Difficulty swallowing and paralysis</li>
                <li>Fear of water (hydrophobia)</li>
                <li>Seizures</li>
            </ul>

            <h3 style="margin-left: 0;">Prevention:</h3>
            <p>Vaccination is the most effective way to prevent rabies in cats. It is important to keep your cat’s
                rabies vaccine up to date. Avoid contact with wild animals and stray cats, as they may carry the virus.
            </p>

            <h3 style="margin-left: 0;">What to Do if You Suspect Rabies:</h3>
            <ul style="padding-left: 20px;">
                <li>Contact a veterinarian immediately</li>
                <li>Keep the cat isolated from other animals</li>
                <li>Seek medical attention for any bites or exposures to saliva from an infected cat</li>
            </ul>
        </div>
    </div>


    <div id="ratRabiesModal" class="modal">
        <div class="modal-content" style="text-align: left;">
            <span class="close" onclick="closeRatRabiesModal()">&times;</span>
            <h2><i class="fa-solid fa-virus"></i> Rat Rabies Information</h2>

            <h3 style="margin-left: 0;">What is Rabies?</h3>
            <p>Rabies is a viral disease that causes inflammation of the brain in mammals, including rats. It is
                primarily transmitted through bites from infected animals, such as wild rats.</p>

            <h3 style="margin-left: 0;">Symptoms in Rats:</h3>
            <ul style="padding-left: 20px;">
                <li>Behavioral changes (aggression, excessive drooling)</li>
                <li>Difficulty moving and paralysis</li>
                <li>Fear of light and disorientation</li>
                <li>Seizures</li>
            </ul>

            <h3 style="margin-left: 0;">Prevention:</h3>
            <p>Vaccination is the most effective way to prevent rabies in rats. While vaccines for rats are not common,
                preventing exposure to wild or stray rats is crucial. Keep your living areas rodent-free to avoid
                contact.</p>

            <h3 style="margin-left: 0;">What to Do if You Suspect Rabies:</h3>
            <ul style="padding-left: 20px;">
                <li>Contact a veterinarian immediately if your pet rat shows symptoms of rabies</li>
                <li>Keep the rat isolated from other animals and humans</li>
                <li>Seek medical attention for any bites or exposures to saliva from a potentially infected rat</li>
            </ul>
        </div>
    </div>







    <section class="home" id="home">

        <div class="content">
            <h3>stay safe around your furbabies</h3>
            <a href="#" class="btn"> read more</a>
        </div>

    </section>

    <section class="services" id="services">

        <h1 class="heading">our services</h1>

        <div class="box-container">

            <div class="box">
                <img src="images/dogbite.jpg" alt="">
                <div class="content">
                    <h3>Dog Anti-Rabies</h3>
                    <a href="#doginfo" class="btn" onclick="openDogRabiesModal()">see details</a>
                </div>
            </div>

            <div class="box">
                <img src="images/catbite.jpg" alt="">
                <div class="content">
                    <h3>Cat Anti-Rabies</h3>
                    <a href="#catinfo" class="btn" onclick="openCatRabiesModal()">See Details</a>
                </div>
            </div>

            <div class="box">
                <img src="images/ratbite.jpg" alt="">
                <div class="content">
                    <h3>Rat Medication</h3>
                    <a href="#ratinfo" class="btn" onclick="openRatRabiesModal()">See Details</a>
                </div>
            </div>

        </div>

    </section>
    <br>
    <br>
    <br>
    <section class="shop-reviews">
        <h2 class="review-title">What Our Customers Say</h2>

        <?php
        $review_query = "SELECT r.message, p.fname, p.lname
                         FROM review r
                         JOIN patient p ON r.user_id = p.user_id";
        $review_result = $conn->query($review_query);

        if ($review_result && $review_result->num_rows > 0) {
            echo '<div class="carousel">';
            echo '    <div class="carousel-inner">';
            while ($row = $review_result->fetch_assoc()) {
                $review_message = htmlspecialchars($row['message']);
                $reviewer_fname = htmlspecialchars($row['fname']);
                $reviewer_lname = htmlspecialchars($row['lname']);
                echo '        <div class="review-card">';
                echo '            <p class="review-text">' . $review_message . '</p>';
                echo '            <h4 class="review-author">- ' . $reviewer_fname . ' ' . $reviewer_lname . '</h4>';
                echo '        </div>';
            }
            echo '    </div>';
            echo '</div>';
            // Basic carousel navigation (you can implement JavaScript for actual sliding)
            if ($review_result->num_rows > 1) {
                echo '<div class="carousel-navigation">';
                echo '    <button onclick="scrollCarousel(\'left\')"><i class="fas fa-chevron-left"></i></button>';
                echo '    <button onclick="scrollCarousel(\'right\')"><i class="fas fa-chevron-right"></i></button>';
                echo '</div>';
            }
        } else {
            echo '<p>No reviews available yet.</p>';
        }
        ?>
    </section>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-quote">
                <h3>“Prevent. Protect. Vaccinate.”</h3>
                <p>Your safety is our priority – Get vaccinated, stay protected.</p>
            </div>

            <div class="footer-info">
                <p><i class="fa-solid fa-map-marker-alt"></i> Address: 123 Health Street, Caloocan City, Philippines</p>
                <p><i class="fa-solid fa-phone"></i> Contact: +63 912 345 6789</p>
                <p><i class="fa-solid fa-envelope"></i> Email: support@animalbiteclinic.com</p>
            </div>

            <div class="footer-credits">
                <p>© 2025 ABC Malaria | All Rights Reserved</p>
                <p>Powered by <strong>Animal Bite Clinic</strong></p>
            </div>
        </div>
    </footer>

    <script>
    (function() {
        if (!window.chatbase || window.chatbase("getState") !== "initialized") {
            window.chatbase = (...arguments) => {
                if (!window.chatbase.q) {
                    window.chatbase.q = []
                }
                window.chatbase.q.push(arguments)
            };
            window.chatbase = new Proxy(window.chatbase, {
                get(target, prop) {
                    if (prop === "q") {
                        return target.q
                    }
                    return (...args) => target(prop, ...args)
                }
            })
        }
        const onLoad = function() {
            const script = document.createElement("script");
            script.src = "https://www.chatbase.co/embed.min.js";
            script.id = "DpaevYyIB0fUF5fMsUmKN";
            script.domain = "www.chatbase.co";
            document.body.appendChild(script)
        };
        if (document.readyState === "complete") {
            onLoad()
        } else {
            window.addEventListener("load", onLoad)
        }
    })();
    </script>

    <script src="js/script.js"></script>
    <script src="js/sweetalert.js"></script>
    <script>
    const carouselInner = document.querySelector('.carousel-inner');
    const reviewCards = document.querySelectorAll('.review-card');
    let currentIndex = 0;
    const cardWidth = reviewCards[0] ? reviewCards[0].offsetWidth + 20 : 0; // Add margin

    function updateCarousel() {
        carouselInner.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    }

    function scrollCarousel(direction) {
        if (direction === 'left') {
            currentIndex = Math.max(currentIndex - 1, 0);
        } else if (direction === 'right') {
            currentIndex = Math.min(currentIndex + 1, reviewCards.length - 1);
        }
        updateCarousel();
    }

    // Make sure the carousel is positioned correctly on load if there are reviews
    window.onload = updateCarousel;
    window.addEventListener('resize', () => {
        // Recalculate cardWidth on resize for responsiveness
        cardWidth = reviewCards[0] ? reviewCards[0].offsetWidth + 20 : 0;
        updateCarousel();
    });

    // Modal functions (assuming these are in your js/script.js)
    // function openDogRabiesModal() {}
    // function closeDogRabiesModal() {}
    // function openCatRabiesModal() {}
    // function closeCatRabiesModal() {}
    // function openRatRabiesModal() {}
    // function closeRatRabiesModal() {}
    </script>

</body>

</html>