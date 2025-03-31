<?php
session_start();
include 'connection.php';
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

</head>

<body>


    <!-- Dog Rabies Modal -->
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

    <!-- Cat Rabies Modal -->
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


    <!-- Rat Rabies Modal -->
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







    <!-- header section ends -->

    <!-- home section starts -->

    <section class="home" id="home">

        <div class="content">
            <h3>stay safe around your furbabies</h3>
            <a href="#" class="btn"> read more</a>
        </div>

    </section>

    <!-- home section ends -->

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

        <div class="carousel">
            <div class="carousel-inner">
                <!-- Review 1 -->
                <div class="review-card">
                    <p class="review-text">"Great service! The staff was very friendly and knowledgeable. Highly
                        recommended!"</p>
                    <h4 class="review-author">- Jane Doe</h4>
                </div>

                <!-- Review 2 -->
                <div class="review-card">
                    <p class="review-text">"I had a smooth experience getting my pet vaccinated. Thank you, ABC!"</p>
                    <h4 class="review-author">- Mark Smith</h4>
                </div>

                <!-- Review 3 -->
                <div class="review-card">
                    <p class="review-text">"Affordable and reliable service. My dog is now protected from rabies!"</p>
                    <h4 class="review-author">- Emily Johnson</h4>
                </div>

                <!-- Review 4 -->
                <div class="review-card">
                    <p class="review-text">"Excellent customer service! They explained everything in detail."</p>
                    <h4 class="review-author">- Alex Brown</h4>
                </div>
            </div>
        </div>
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

</body>

</html>