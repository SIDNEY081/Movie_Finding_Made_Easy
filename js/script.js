// Movie Finding Website - Enhanced JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Movie Finding Made Easy - Initializing...');

    // === Mobile Navigation Toggle ===
    initializeMobileMenu();

    // === Scroll to Top Functionality ===
    initializeScrollToTop();

    // === Smooth Scrolling ===
    initializeSmoothScrolling();

    // === Movie Card Animations ===
    initializeMovieAnimations();

    // === Search Form Enhancement ===
    initializeSearchForm();

    // === Contact Form Enhancement ===
    initializeContactForm();

    // === Image Loading Handling ===
    initializeImageLoading();

    console.log('All features initialized successfully');
});

// Mobile Menu Functionality
function initializeMobileMenu() {
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const header = document.querySelector('header');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle menu
            navMenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
            
            // Update aria-expanded for accessibility
            const isExpanded = navMenu.classList.contains('active');
            menuToggle.setAttribute('aria-expanded', isExpanded);
            
            console.log('Mobile menu toggled:', isExpanded);
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!header.contains(e.target) && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close menu when clicking on a link (for single page navigation)
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                if (navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                    menuToggle.classList.remove('active');
                    menuToggle.setAttribute('aria-expanded', 'false');
                }
            });
        });
    }
}

// Scroll to Top Functionality
function initializeScrollToTop() {
    const scrollBtn = document.getElementById('scrollTopBtn');

    if (scrollBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollBtn.style.display = 'block';
                setTimeout(() => scrollBtn.classList.add('visible'), 10);
            } else {
                scrollBtn.classList.remove('visible');
                setTimeout(() => {
                    if (!scrollBtn.classList.contains('visible')) {
                        scrollBtn.style.display = 'none';
                    }
                }, 300);
            }
        });

        // Smooth scroll to top
        scrollBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Hide button initially
        scrollBtn.style.display = 'none';
    }
}

// Smooth Scrolling for Navigation
function initializeSmoothScrolling() {
    document.addEventListener('click', function(e) {
        // Handle navigation links
        if (e.target.matches('nav a') || e.target.closest('nav a')) {
            const link = e.target.matches('nav a') ? e.target : e.target.closest('nav a');
            const href = link.getAttribute('href');
            
            // Only handle internal links
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                if (targetElement) {
                    const headerHeight = document.querySelector('header').offsetHeight;
                    const targetPosition = targetElement.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        }
    });
}

// Movie Card Animations
function initializeMovieAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Animate movie cards
    const movieCards = document.querySelectorAll('.movie-card');
    movieCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // Add hover effects
    movieCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Search Form Enhancement
function initializeSearchForm() {
    const searchForm = document.getElementById('search-form');
    
    if (searchForm) {
        const searchInput = searchForm.querySelector('input[name="search"]');
        
        // Clear search when clicking on logo
        const logo = document.querySelector('.logo');
        if (logo) {
            logo.addEventListener('click', function() {
                if (searchInput) {
                    searchInput.value = '';
                }
            });
        }

        // Add input validation
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                if (this.value.length > 50) {
                    this.value = this.value.substring(0, 50);
                }
            });
        }

        // Prevent empty searches
        searchForm.addEventListener('submit', function(e) {
            if (searchInput && searchInput.value.trim() === '') {
                e.preventDefault();
                searchInput.focus();
                searchInput.placeholder = 'Please enter a search term...';
                setTimeout(() => {
                    searchInput.placeholder = 'Search for a movie or series...';
                }, 2000);
            }
        });
    }
}

// Contact Form Enhancement
function initializeContactForm() {
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        const inputs = contactForm.querySelectorAll('input, textarea');
        
        // Add real-time validation
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });

        // Form submission enhancement
        contactForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = contactForm.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }
}

// Field validation helper
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';

    // Clear previous error
    clearFieldError(field);

    // Validation rules
    if (field.hasAttribute('required') && !value) {
        errorMessage = 'This field is required';
        isValid = false;
    } else if (field.type === 'email' && value && !isValidEmail(value)) {
        errorMessage = 'Please enter a valid email address';
        isValid = false;
    } else if (field.hasAttribute('minlength') && value.length < field.getAttribute('minlength')) {
        errorMessage = `Minimum ${field.getAttribute('minlength')} characters required`;
        isValid = false;
    }

    if (!isValid) {
        showFieldError(field, errorMessage);
    }

    return isValid;
}

// Email validation helper
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Show field error
function showFieldError(field, message) {
    field.classList.add('error');
    
    let errorElement = field.parentNode.querySelector('.field-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        field.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
}

// Clear field error
function clearFieldError(field) {
    field.classList.remove('error');
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

// Image Loading Handling
function initializeImageLoading() {
    const images = document.querySelectorAll('img[data-src], .movie-card img');
    
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.getAttribute('data-src') || img.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }
                                    🗑️ Delete

    // Handle broken images
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjUwIiBoZWlnaHQ9IjM1MCIgdmlld0JveD0iMCAwIDI1MCAzNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyNTAiIGhlaWdodD0iMzUwIiBmaWxsPSIjMWExYTFhIi8+Cjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0iI2ZmM2MzYyIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE0Ij5Nb3ZpZSBJbWFnZTwvdGV4dD4KPC9zdmc+';
            this.alt = 'Image not available';
        });
    });
}

// Utility function for debouncing
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Make functions available globally for debugging
window.movieApp = {
    refresh: function() {
        location.reload();
    },
    testMenu: function() {
        const menuToggle = document.getElementById('menu-toggle');
        if (menuToggle) menuToggle.click();
    },
    testScroll: function() {
        const scrollBtn = document.getElementById('scrollTopBtn');
        if (scrollBtn) scrollBtn.click();
    }
};

console.log('Movie Finding Made Easy - JavaScript loaded successfully');

// ===== LANDING PAGE FUNCTIONALITY =====
function initializeLandingPage() {
    const bgVideo = document.getElementById('bgVideo');
    const loadingScreen = document.getElementById('loadingScreen');
    const soundToggle = document.getElementById('soundToggle');
    const soundIcon = soundToggle?.querySelector('.sound-icon');
    
    // Only run if we're on the landing page
    if (!bgVideo || !loadingScreen) return;
    
    console.log('Initializing landing page...');
    
    // Hide loading screen when video is loaded
    bgVideo.addEventListener('loadeddata', function() {
        loadingScreen.classList.add('hidden');
        console.log('Background video loaded, hiding loading screen');
    });

    // Fallback in case video takes too long to load
    setTimeout(function() {
        if (!loadingScreen.classList.contains('hidden')) {
            loadingScreen.classList.add('hidden');
            console.log('Loading screen hidden by fallback timeout');
        }
    }, 3000);

    // Handle video loading errors
    bgVideo.addEventListener('error', function() {
        console.error('Error loading background video');
        loadingScreen.classList.add('hidden');
        
        // Set a fallback background
        document.body.style.background = 'linear-gradient(135deg, #0e0e0e, #1a1a1a)';
    });

    // Sound toggle functionality
    if (soundToggle && soundIcon) {
        soundToggle.addEventListener('click', function() {
            if (bgVideo.muted) {
                // Unmute the video
                bgVideo.muted = false;
                soundIcon.textContent = '🔊'; // Speaker icon
                soundToggle.classList.remove('sound-off');
                soundToggle.classList.add('sound-on');
                console.log('Video unmuted');
            } else {
                // Mute the video
                bgVideo.muted = true;
                soundIcon.textContent = '🔇'; // Muted speaker icon
                soundToggle.classList.remove('sound-on');
                soundToggle.classList.add('sound-off');
                console.log('Video muted');
            }
        });

        // Initialize sound toggle state
        soundToggle.classList.add('sound-off');
    }

    // Add click event for the enter button
    const enterBtn = document.querySelector('.enter-btn');
    if (enterBtn) {
        enterBtn.addEventListener('click', function(e) {
            // Add a loading state to the button
            const originalText = this.textContent;
            this.textContent = 'Loading...';
            this.style.opacity = '0.8';
            
            // Reset after a short delay (navigation will happen via href)
            setTimeout(() => {
                this.textContent = originalText;
                this.style.opacity = '1';
            }, 2000);
        });
    }

    // Add keyboard support for accessibility
    document.addEventListener('keydown', function(e) {
        // Enter key to trigger the Get Started button
        if (e.key === 'Enter' && document.activeElement === document.body) {
            const enterBtn = document.querySelector('.enter-btn');
            if (enterBtn) {
                enterBtn.click();
            }
        }
        
        // Space key to toggle sound
        if (e.key === ' ' && soundToggle) {
            e.preventDefault();
            soundToggle.click();
        }
        
        // M key to toggle sound
        if (e.key === 'm' || e.key === 'M') {
            if (soundToggle) {
                soundToggle.click();
            }
        }
    });
}

// Initialize landing page if we're on that page
document.addEventListener('DOMContentLoaded', function() {
    initializeLandingPage();
});

// ===== ADMIN DASHBOARD FUNCTIONALITY =====
function initializeAdminDashboard() {
    // Toggle edit forms
    const toggleEditButtons = document.querySelectorAll('.toggle-edit');
    if (toggleEditButtons.length > 0) {
        toggleEditButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const editForm = document.getElementById(targetId);
                if (editForm.style.display === 'none') {
                    editForm.style.display = 'block';
                } else {
                    editForm.style.display = 'none';
                }
            });
        });
    }

    // Auto-close success message after 5 seconds
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    }
}

// Initialize admin dashboard if we're on that page
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on admin dashboard by looking for admin-header
    const adminHeader = document.querySelector('.admin-header');
    if (adminHeader) {
        initializeAdminDashboard();
    } else {
        // Run regular site initializations
        initializeMobileMenu();
        initializeScrollToTop();
        initializeSmoothScrolling();
        initializeMovieAnimations();
        initializeSearchForm();
        initializeContactForm();
        initializeImageLoading();
        initializeLandingPage();
    }
});