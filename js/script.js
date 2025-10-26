// === Responsive Navigation Toggle ===
const menuToggle = document.getElementById('menu-toggle');
const navMenu = document.querySelector('.nav-menu');

if (menuToggle && navMenu) {
  menuToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
  });
}

// === Scroll-to-Top Button ===
const scrollBtn = document.getElementById('scrollTopBtn');

if (scrollBtn) {
  window.addEventListener('scroll', () => {
    scrollBtn.style.display = window.scrollY > 300 ? 'block' : 'none';
  });

  scrollBtn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

// === Dynamic Greeting (Home Page Only) ===
const greeting = document.getElementById('greeting');

if (greeting) {
  const hour = new Date().getHours();
  if (hour < 12) {
    greeting.textContent = 'Good morning, welcome to Movie Finding Made Easy!';
  } else if (hour < 18) {
    greeting.textContent = 'Good afternoon, welcome to Movie Finding Made Easy!';
  } else {
    greeting.textContent = 'Good evening, welcome to Movie Finding Made Easy!';
  }
}

// === Initialize Bootstrap Tooltips ===
const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// === Scroll Animation for Movie Cards ===
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('fade-in');
    }
  });
}, observerOptions);

const movieCards = document.querySelectorAll('.movie-card');
movieCards.forEach(card => {
  observer.observe(card);
});
