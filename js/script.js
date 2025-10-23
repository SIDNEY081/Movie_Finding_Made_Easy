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
