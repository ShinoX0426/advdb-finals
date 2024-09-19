
// Banner Section
const slider = document.querySelector('.banner-slider');
const slides = slider.querySelectorAll('.slide');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
const navIndicators = document.querySelectorAll('.nav-indicator');

let currentSlide = 0;

slides[currentSlide].style.display = 'block';

prevBtn.addEventListener('click', () => {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    updateSlider();
});

nextBtn.addEventListener('click', () => {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    updateSlider();
});

navIndicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        currentSlide = index;
        updateSlider();
    });
});

function updateSlider() {
    slides.forEach((slide) => {
        slide.style.display = 'none';
    });

    slides[currentSlide].style.display = 'block';

    navIndicators.forEach((indicator, index) => {
        if (index === currentSlide) {
            indicator.classList.add('active');
        } else {
            indicator.classList.remove('active');
        }
    });
}

// Announcement
// Announcement Section
const announcementSlider = document.querySelector('.announcement-slider');
const announcementSlides = announcementSlider.querySelectorAll('.announcement-slide');
const announcementPrevBtn = document.querySelector('.announcement-prev-btn');
const announcementNextBtn = document.querySelector('.announcement-next-btn');

let currentAnnouncement = 0;

announcementSlides[currentAnnouncement].classList.add('active');

announcementPrevBtn.addEventListener('click', () => {
    currentAnnouncement--;
    if (currentAnnouncement < 0) {
        currentAnnouncement = announcementSlides.length - 1;
    }
    updateAnnouncementSlider();
});

announcementNextBtn.addEventListener('click', () => {
    currentAnnouncement++;
    if (currentAnnouncement >= announcementSlides.length) {
        currentAnnouncement = 0;
    }
    updateAnnouncementSlider();
});

function updateAnnouncementSlider() {
    announcementSlides.forEach((slide) => {
        slide.classList.remove('active');
    });

    announcementSlides[currentAnnouncement].classList.add('active');
}
