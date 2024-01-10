document.addEventListener('DOMContentLoaded', function() {
    let loginModal = document.getElementById('loginModal');

    // Check for the login button and the user button
    let loginBtn = document.querySelector('.login-btn');
    let userBtn = document.querySelector('.user-btn');
    let spanClose = loginModal.querySelector('.close-btn');

    // Set event listener for login button if it exists
    if (loginBtn) {
        loginBtn.onclick = function(event) {
            event.preventDefault();
            loginModal.style.display = 'block';
        }
    }

    // You can set a different event listener for userBtn if needed
    if (userBtn) {
        userBtn.onclick = function(event) {
            event.preventDefault();
            loginModal.style.display = 'block';
        }
    }

    // Close the modal
    if (spanClose) {
        spanClose.onclick = function() {
            loginModal.style.display = 'none';
        }
    }

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target === loginModal) {
            loginModal.style.display = 'none';
        }
    }
});
