    const loginBtn = document.getElementById('loginBtn');
    const loginModal = document.getElementById('loginModal');
    const closeBtn = document.getElementsByClassName('close')[0];

    // Error message container
    const errorElement = document.getElementById('errorMessage');

    // Function to check if there's an error
    function hasError() {
        // Check if errorElement contains any text (indicating an error)
        return errorElement && errorElement.innerText.trim() !== '';
    }

    // Open the login modal when the login button is clicked
    loginBtn.onclick = function () {
        loginModal.style.display = "block";
    }

    // Close the modal if there's no error when the close button is clicked
    closeBtn.onclick = function () {
        if (!hasError()) {
            loginModal.style.display = "none";
        }
    }

    // Close the modal if the user clicks outside the modal, but only if there's no error
    window.onclick = function (event) {
        if (event.target == loginModal && !hasError()) {
            loginModal.style.display = "none";
        }
    }


// Smooth Scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Announcement Slider
const announcements = document.querySelectorAll('.announcement');
let currentAnnouncement = 0;

function showNextAnnouncement() {
    announcements[currentAnnouncement].style.display = 'none';
    currentAnnouncement = (currentAnnouncement + 1) % announcements.length;
    announcements[currentAnnouncement].style.display = 'block';
}

setInterval(showNextAnnouncement, 5000);

// Form Submission
const contactForm = document.querySelector('.contact-form');

contactForm.addEventListener('submit', function (e) {
    e.preventDefault();

    // Here you would typically send the form data to a server
    // For this example, we'll just log it to the console
    console.log('Form submitted');

    // Clear the form
    this.reset();

    // Show a success message
    alert('Thank you for your message. We will get back to you soon!');
});

