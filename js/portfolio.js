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
const hamburger = document.querySelector('.hamburger');

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

    // Animation de l'hamburger
    .from(hamburger, 1, { opacity: 0, x: 100, ease: "power2.out" }, '-=1')

    // Animation du texte de présentation
    .from(presentation, 1, { opacity: 0, y: 30, ease: "power2.out" }, '-=0.8');

  // Lecture de l'animation
  TL.play();
});


// Récupérer l'élément HTML de sous-titre
const texteAnimé = document.querySelector('.subtitle');

// Créer une nouvelle instance de Typewriter.js pour l'élément
const typewriter = new Typewriter(texteAnimé, {
    loop: true,  // Permet de boucler l'animation
    delay: 75,   // Vitesse d'écriture (en millisecondes)
    deleteSpeed: 50,  // Vitesse de suppression des caractères (plus lent)
});

// Configurer les étapes d'animation
typewriter
    .typeString("Je suis")  // Le texte à afficher
    .pauseFor(1000)  // Pause de 1 seconde avant de supprimer
    .typeString("<strong>, Développeur</strong>!")
    .pauseFor(1000)  // Augmenter la pause avant suppression
    .deleteChars(13)  // Supprimer les caractères (s'il s'agit de toute la phrase)
    .typeString('<span style="color: #27ae60 ;"> CSS </span> !')
    .pauseFor(1000)
    .deleteChars(6)
    .typeString('<span style="color: midnightblue;"> HTML </span> !')
    .pauseFor(1000)
    .deleteChars(7)
    .typeString('<span style="color: #ea39ff; "> PHP </span> !')
    .pauseFor(1000)
    .deleteChars(6)
    .typeString('<span style="color: #ff6910; "> JavaScript </span> !')
    .pauseFor(1000)
    .deleteChars(12) // Ajustez ici si nécessaire
    .start();  // Démarrer l'animation
