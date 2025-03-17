document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.querySelector(".menu-toggle");
    const nav = document.querySelector("nav");
  
    menuToggle.addEventListener("click", function() {
      nav.classList.toggle("active");
    });
  });
  
  
  
  window.addEventListener('scroll', function() {
    var navbar = document.querySelector('.nav-laterale');
    var sticky = navbar.offsetTop;
  
    if (window.pageYOffset >= sticky) {
        navbar.classList.add('sticky');
    } else {
        navbar.classList.remove('sticky');
    }
  });
  
  document.querySelector('.menu-toggle').addEventListener('click', function() {
    document.querySelector('.nom-nav').classList.toggle('show');
  });