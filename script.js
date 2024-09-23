// Login Modal
const loginBtn = document.getElementById('loginBtn');
const loginModal = document.getElementById('loginModal');
const closeBtn = document.getElementsByClassName('close')[0];

loginBtn.onclick = function () {
    loginModal.style.display = "block";
}

closeBtn.onclick = function () {
    loginModal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == loginModal) {
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

