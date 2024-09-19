<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Don Pablo Lorenzo Memorial High School</title>
    <link rel="shortcut icon" href="../../../FINAL/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .login-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
        }

        .login-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            z-index: 1001;
        }

        .login-popup h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0f3978;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: #fd9619;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .login-btn:hover {
            background-color: #ffc664;
            color: black;
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #0f3978;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <menu class="topMenu flex">
        <section class="flexContent">
            <a href="emailto:info@lilliovi.com">
                <i class="fa fa-envelope-o"></i>
                DonPablo@dplmhs.edu.com
            </a>
            <a href="tel:1234567890">
                <i class="fa fa-phone"></i>
                90921021
            </a>
        </section>
        <section class="flexContent">
            <a href="#" title="Facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" title="Instagram"><i class="fa fa-instagram"></i></a>
            <a href="#" title="Twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" title="youtube"><i class="fa fa-youtube"></i></a>
        </section>
    </menu>

    <header>
        <nav>
            <div class="logo">
                <img src=".../../../FINAL/images/logo.png" alt="Logo">
                <span>Don Pablo Guidance</span>
            </div>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <div class="login">
                <a href="login.php">Login</a>
            </div>
        </nav>
    </header>

    <div class="banner">
        <div class="banner-slider">
            <div class="slide">
                <img src="../../../FINAL/images/banner.jpg" alt="Banner 1">
                <div class="slide-content">
                    <h2>Slide dasd</h2>
                    <p>Slide 1 description</p>
                </div>
            </div>
            <div class="slide">
                <img src="../../../FINAL/images/banner.jpg" alt="Banner 2">
                <div class="slide-content">
                    <h2>Slide 2 Title</h2>
                    <p>Slide 2 description</p>
                </div>
            </div>
            <div class="slide">
                <img src="../../../FINAL/images/banner.jpg" alt="Banner 3">
                <div class="slide-content">
                    <h2>Slide 3 Title</h2>
                    <p>Slide 3 description</p>
                </div>
            </div>
        </div>
        <div class="nav-buttons">
            <button class="prev-btn">Prev</button>
            <button class="next-btn">Next</button>
        </div>
        <div class="nav-indicators">
            <button class="nav-indicator" data-slide="0"></button>
            <button class="nav-indicator" data-slide="1"></button>
            <button class="nav-indicator" data-slide="2"></button>
        </div>
    </div>

    <!-- Announcement Section -->
    <div class="announcement">
        <div class="announcement-content">
            <h2>Announcements</h2>
            <div class="announcement-slider">
                <div class="announcement-slide active">
                    <div class="announcement-event">
                        <h3>Upcoming Event: School Fair</h3>
                        <p>Date: Saturday, April 17th</p>
                        <p>Time: 10am-2pm</p>
                        <p>Location: School Grounds</p>
                        <button class="announcement-btn">Learn More</button>
                    </div>
                    <div class="announcement-notification">
                        <i class="fa fa-bell"></i>
                        <p>Don't forget to mark your calendars for the school fair!</p>
                    </div>
                </div>
                <div class="announcement-slide">
                    <div class="announcement-event">
                        <h3>Important Deadline: Scholarship Applications</h3>
                        <p>Date: March 31st</p>
                        <p>Time: 11:59pm</p>
                        <p>Location: Online Application Portal</p>
                        <button class="announcement-btn">Apply Now</button>
                    </div>
                    <div class="announcement-notification">
                        <i class="fa fa-bell"></i>
                        <p>Don't miss out on this opportunity to receive financial assistance for your education!</p>
                    </div>
                </div>
                <div class="announcement-slide">
                    <div class="announcement-event">
                        <h3>Staff Development Day</h3>
                        <p>Date: Friday, March 19th</p>
                        <p>Time: All Day</p>
                        <p>Location: School Campus</p>
                        <button class="announcement-btn">Learn More</button>
                    </div>
                    <div class="announcement-notification">
                        <i class="fa fa-bell"></i>
                        <p>The school will be closed on Friday, March 19th for a staff development day.</p>
                    </div>
                </div>
            </div>
            <div class="announcement-nav">
                <button class="announcement-prev-btn">Prev</button>
                <button class="announcement-next-btn">Next</button>
            </div>
        </div>
    </div>


    <!-- About Us section -->

    <div class="about-us">
        <div class="container">
            <h2 class="title">About Us</h2>
            <p class="subtitle">Welcome to Don Pablo Lorenzo Memorial High School!</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="mission-box">
                        <h3>Our Mission</h3>
                        <p>Our mission is to provide a comprehensive education that prepares students for success in an
                            ever-changing world. We strive to create a culture of excellence, innovation, and creativity
                            that inspires students to reach their full potential.</p>
                        <img src="../../../FINAL/images/mission-icon.png" alt="Mission Icon">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="vision-box">
                        <h3>Our Vision</h3>
                        <p>Our vision is to be a leading institution in education, recognized for our commitment to
                            academic excellence, diversity, and community engagement. We aim to produce graduates who
                            are critical thinkers, effective communicators, and responsible citizens.</p>
                        <img src="../../../FINAL/images/vision-icon.png" alt="Vision Icon">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="history-box">
                        <h3>Our History</h3>
                        <p>Don Pablo Lorenzo Memorial High School was founded in [year] with the goal of providing a
                            quality education to students in the local community. Since then, we have grown to become a
                            thriving institution with a strong reputation for academic excellence and community service.
                        </p>
                        <img src="../../../FINAL/images/history-icon.png" alt="History Icon">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="values-box">
                        <h3>Our Values</h3>
                        <ul>
                            <li><i class="fa fa-graduation-cap"></i> Academic Excellence</li>
                            <li><i class="fa fa-user"></i> Personal Growth</li>
                            <li><i class="fa fa-globe"></i> Social Responsibility</li>
                            <li><i class="fa fa-users"></i> Inclusivity and Diversity</li>
                            <li><i class="fa fa-handshake"></i> Community Engagement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-overlay" id="loginOverlay">
        <div class="login-popup">
            <span class="close-btn" id="closeLogin">&times;</span>
            <h2>Login</h2>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle login popup
        document.addEventListener('DOMContentLoaded', function () {
            const loginButton = document.querySelector('.login a');
            const loginOverlay = document.getElementById('loginOverlay');
            const closeLogin = document.getElementById('closeLogin');

            loginButton.addEventListener('click', function (e) {
                e.preventDefault();
                loginOverlay.style.display = 'block';
            });

            closeLogin.addEventListener('click', function () {
                loginOverlay.style.display = 'none';
            });

            loginOverlay.addEventListener('click', function (e) {
                if (e.target === loginOverlay) {
                    loginOverlay.style.display = 'none';
                }
            });
        });
    </script>

    <script src="script.js"></script>
</body>

</html>