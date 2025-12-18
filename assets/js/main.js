document.addEventListener("DOMContentLoaded", function () {
  const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
  const mainNav = document.querySelector(".main-nav");

  if (mobileNavToggle && mainNav) {
    mobileNavToggle.addEventListener("click", function () {
      // This will toggle a class 'active' on the navigation menu
      mainNav.classList.toggle("nav-active");

      // This will toggle a class on the hamburger for animation (e.g., to an 'X')
      mobileNavToggle.classList.toggle("is-active");
    });
  }
});

/* ==========================================================================
   Gallery Page Functionality (Filtering & Lightbox)
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // --- Gallery Filtering Logic ---
    const filterContainer = document.querySelector('#gallery-filters');
    const galleryItems = document.querySelectorAll('.gallery-item');

    if (filterContainer && galleryItems.length > 0) {
        filterContainer.addEventListener('click', function(e) {
            // Only run if a filter-btn is clicked
            if (e.target.classList.contains('filter-btn')) {
                // De-activate all buttons
                filterContainer.querySelector('.active').classList.remove('active');
                // Activate the clicked button
                e.target.classList.add('active');

                const filterValue = e.target.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (item.classList.contains(filterValue) || filterValue === '*') {
                        item.style.display = 'block'; // Show item
                    } else {
                        item.style.display = 'none'; // Hide item
                    }
                });
            }
        });
    }


    // --- Lightbox Logic ---
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxClose = document.querySelector('.lightbox-close');

    if (lightbox && lightboxImg && lightboxCaption && lightboxClose) {
        
        galleryItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                
                lightbox.style.display = 'flex';
                lightboxImg.src = this.href;
                lightboxCaption.innerHTML = this.getAttribute('data-caption');
            });
        });

        // Close lightbox when 'x' is clicked
        lightboxClose.addEventListener('click', function() {
            lightbox.style.display = 'none';
        });

        // Close lightbox when clicking outside the image
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                lightbox.style.display = 'none';
            }
        });
    }

});
/* ==========================================================================
   Admin Login - Show/Hide Password
   ========================================================================== */
document.addEventListener('DOMContentLoaded', function() {

    const passwordField = document.getElementById('password-field');
    const togglePassword = document.getElementById('toggle-password');

    if (passwordField && togglePassword) {
        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle the eye icon
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

});
/* ==========================================================================
       Phone Number Input Validation (Prevent typing text)
       ========================================================================== */
    const phoneInput = document.getElementById('phone');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // This regex replaces any character that is NOT a number, space, +, -, (, or ) with an empty string.
            this.value = this.value.replace(/[^0-9\-\+\s\(\)]/g, '');
        });
    }
    /* ==========================================================================
   Hidden Admin Login Link
   ========================================================================== */
document.addEventListener('DOMContentLoaded', function() {
    
    // Find all logo links (in header and footer)
    const logoLinks = document.querySelectorAll('.logo-link');

    if (logoLinks.length > 0) {
        let clickCount = 0;
        let clickTimer = null;

        logoLinks.forEach(logo => {
            logo.addEventListener('click', function(event) {
                // Prevent the link from navigating immediately
                event.preventDefault();

                clickCount++;

                // If this is the 5th click, redirect to the admin page
                if (clickCount === 5) {
                    window.location.href = 'admin/index.php';
                    return; // Stop the function here
                }

                // If the user clicks multiple times, we need a timer.
                // If they wait too long between clicks, the counter resets.
                clearTimeout(clickTimer);
                clickTimer = setTimeout(() => {
                    clickCount = 0; // Reset counter after 1.5 seconds of inactivity
                }, 2000);

                // If it's the first click and the timer is running, just go to the homepage
                if (clickCount === 1) {
                   setTimeout(() => {
                       // Only navigate to homepage if counter hasn't increased
                       if (clickCount === 1) {
                           window.location.href = this.href || 'index.php';
                       }
                   }, 300); // A small delay to allow for double-clicks etc.
                }
            });
        });
    }

});