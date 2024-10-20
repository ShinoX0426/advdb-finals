<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Don Pablo Lorenzo Memorial High School</title>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* The custom alert box */
        .custom-alert {
            z-index: 2; /* Make sure it stays above the background overlay */
            position: absolute; 
            left: 50%; 
            top: 50%;
            transform: translate(-50%, -50%); /* Perfectly centers the alert */
            background-color: #f44336; /* Red background */
            color: white; /* White text */
            padding: 20px; /* Some padding */
            border-radius: 10px; /* Rounded corners */
            text-align: center; /* Center the text */
            width: 300px; /* Set width for the alert box */
        }

        /* The overlay that blurs the background */
        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent dark overlay */
            backdrop-filter: blur(5px); /* Blurs the background */
            z-index: 1; /* Sits behind the alert */
        }
</style>
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="images/logo.png" alt="School Logo">
                <h1>Don Pablo Lorenzo Memorial High School</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#announcements">Announcements</a></li>
                    <li><a href="#events">Events</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            <div class="login-btn">
                <?php if (isset($_SESSION['account'])): ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="#" id="loginBtn">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <section id="home" class="hero">
            <div class="container">
                <h2>Welcome to Don Pablo Lorenzo Memorial High School</h2>
                <p>Empowering minds, shaping futures</p>
                <a href="#about" class="cta-btn">Learn More</a>
            </div>
        </section>

        <section id="about" class="about">
            <div class="container">
                <h2>About Us</h2>
                <div class="about-content">
                    <div class="about-text">
                        <p>Don Pablo Lorenzo Memorial High School is committed to providing quality education and
                            fostering a nurturing environment for our students. Our dedicated faculty and staff work
                            tirelessly to ensure that each student reaches their full potential.</p>
                        <ul>
                            <li><i class="fas fa-check"></i> Excellence in academics</li>
                            <li><i class="fas fa-check"></i> Holistic development</li>
                            <li><i class="fas fa-check"></i> Community engagement</li>
                        </ul>
                    </div>
                    <div class="about-image">
                        <img src="images/About.jpg" alt="School Building">
                    </div>
                </div>
            </div>
        </section>

        <section id="announcements" class="announcements">
            <div class="container">
                <h2>Announcements</h2>
                <div class="announcement-slider">
                    <div class="announcement">
                        <h3>School Reopening</h3>
                        <p>We are excited to announce that the school will reopen on August 15th, 2023. Please ensure
                            all necessary preparations are made.</p>
                    </div>
                    <div class="announcement">
                        <h3>New Online Learning Platform</h3>
                        <p>We have launched a new online learning platform to support our students' education. Login
                            details will be sent to all parents and students soon.</p>
                    </div>
                    <div class="announcement">
                        <h3>Parent-Teacher Conference</h3>
                        <p>The annual parent-teacher conference is scheduled for September 5th, 2023. More details will
                            be shared via email.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="events" class="events">
            <div class="container">
                <h2>Upcoming Events</h2>
                <div class="event-list">
                    <div class="event">
                        <div class="event-date">
                            <span class="day">15</span>
                            <span class="month">Aug</span>
                        </div>
                        <div class="event-details">
                            <h3>First Day of School</h3>
                            <p>Welcome back all students for the new academic year!</p>
                        </div>
                    </div>
                    <div class="event">
                        <div class="event-date">
                            <span class="day">05</span>
                            <span class="month">Sep</span>
                        </div>
                        <div class="event-details">
                            <h3>Parent-Teacher Conference</h3>
                            <p>Annual meeting for parents and teachers to discuss student progress.</p>
                        </div>
                    </div>
                    <div class="event">
                        <div class="event-date">
                            <span class="day">20</span>
                            <span class="month">Oct</span>
                        </div>
                        <div class="event-details">
                            <h3>Science Fair</h3>
                            <p>Students showcase their innovative science projects.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="contact">
            <div class="container">
                <h2>Contact Us</h2>
                <div class="contact-content">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p><i class="fas fa-map-marker-alt"></i> 123 School Street, City, State 12345</p>
                        <p><i class="fas fa-phone"></i> (123) 456-7890</p>
                        <p><i class="fas fa-envelope"></i> info@dplmhs.edu</p>
                        <div class="social-links">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <form class="contact-form">
                        <input type="text" placeholder="Your Name" required>
                        <input type="email" placeholder="Your Email" required>
                        <textarea placeholder="Your Message" required></textarea>
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 Don Pablo Lorenzo Memorial High School. All rights reserved.</p>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
            </ul>
        </div>
    </footer>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login</h2>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </div>
    </div>

    <script>
        // Check if there's an error in the PHP session
        <?php if (isset($_SESSION['error'])): ?>
            var errorMessage = "<?php echo $_SESSION['error']; ?>";
            alert(errorMessage);
            <?php unset($_SESSION['error']); // Clear the error after displaying it ?>
        <?php endif; ?>
    </script>

    <script src="script.js"></script>
</body>

</html>