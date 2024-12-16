document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const navbar = document.getElementById("navbar");

    hamburger.addEventListener("click", function () {
        navbar.classList.toggle("open");
        hamburger.classList.toggle("open");
    });
});

// Sélection des éléments pour l'animation
const titreSpans = document.querySelectorAll('.hero-content span'); // Texte du titre
const btns = document.querySelectorAll('.navbar nav a'); // Liens du menu
const logo = document.querySelector('.logo'); // Logo
const medias = document.querySelectorAll('.circle'); // Cercles décoratifs
const heroImage = document.querySelector('.hero-image img'); // Image principale
const presentation = document.querySelector('.presentation'); // Texte de présentation

// Animation au chargement de la page
window.addEventListener('load', () => {
  const TL = gsap.timeline({ paused: true });

  TL
    // Animation du titre
    .staggerFrom(titreSpans, 1, { top: -50, opacity: 0, ease: "power2.out" }, 0.3)

    // Animation des boutons de navigation
    .staggerFrom(btns, 1, { opacity: 0, y: -20, ease: "power2.out" }, 0.2, '-=0.8')

    // Animation du logo
    .from(logo, 0.6, { transform: "scale(0)", ease: "power2.out" }, '-=1')

    // Animation des cercles décoratifs
    .staggerFrom(medias, 1, { scale: 0, opacity: 0, ease: "elastic.out(1, 0.5)" }, 0.3, '-=0.8')

    // Animation de l'image principale
    .from(heroImage, 1, { opacity: 0, x: 100, ease: "power2.out" }, '-=1')

    // Animation du texte de présentation
    .from(presentation, 1, { opacity: 0, y: 30, ease: "power2.out" }, '-=0.8');

  // Lecture de l'animation
  TL.play();
});
