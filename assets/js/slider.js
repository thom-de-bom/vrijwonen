document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;
    let isInitialLoad = true; // Flag to check if it's the initial page load

    const showSlide = (index) => {
        if (index >= 0 && index < slides.length) {
            if (currentSlide >= 0 && currentSlide < slides.length) {
                slides[currentSlide].classList.remove('slide-active', 'slide-from-top', 'slide-from-right', 'slide-from-bottom', 'slide-from-left');
            }

            if (!isInitialLoad) {
                switch (index) {
                    case 0:
                        slides[index].classList.add('slide-from-top');
                        break;
                    case 1:
                        slides[index].classList.add('slide-from-right');
                        break;
                    case 2:
                        slides[index].classList.add('slide-from-bottom');
                        break;
                    case 3:
                        slides[index].classList.add('slide-from-left');
                        break;
                }
            }

            slides[index].classList.add('slide-active');
            currentSlide = index;
            isInitialLoad = false; // Set to false after the first load
        }
    };

    const navLinks = {
        'navHome': 0,
        'navWoningen': 1,
        'navContact': 2,
        'navAbout': 3
    };

    Object.keys(navLinks).forEach(navId => {
        document.getElementById(navId).addEventListener('click', () => {
            showSlide(navLinks[navId]);
        });
    });
    // Initialize the first slide as active
    showSlide(0);
});
