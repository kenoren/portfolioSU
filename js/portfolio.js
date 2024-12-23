document.addEventListener("DOMContentLoaded", function () {

  const hamburger = document.getElementById("hamburger");
  const navbar = document.getElementById("navbar");

  if (hamburger && navbar) {
      hamburger.addEventListener("click", function () {
          navbar.classList.toggle("open");
          hamburger.classList.toggle("open");
      });
  }

 
  const titreSpans = document.querySelectorAll('.hero-content span');
  const btns = document.querySelectorAll('.navbar a');
  const logo = document.querySelector('.logo');
  const medias = document.querySelectorAll('.circle');
  const heroImage = document.querySelector('.hero-image img');
  const presentation = document.querySelector('.presentation');
  const subtitle = document.querySelector('.subtitle');


  if (typeof gsap !== 'undefined') {
      const TL = gsap.timeline({ paused: true });

      TL
          .from(titreSpans, { duration: 1, top: -50, opacity: 0, ease: "power2.out", stagger: 0.3 })
          .from(btns, { duration: 1, opacity: 0, y: -20, ease: "power2.out", stagger: 0.2 }, '-=0.8')
          .from(logo, { duration: 0.6, scale: 0, ease: "power2.out" }, '-=1')
          .from(medias, { duration: 1, scale: 0, opacity: 0, ease: "elastic.out(1, 0.5)", stagger: 0.3 }, '-=0.8')
          .from(heroImage, { duration: 1, opacity: 0, x: 100, ease: "power2.out" }, '-=1')
          .from(subtitle, { duration: 1, opacity: 0, y: 30, ease: "power2.out" }, '-=0.8')
          .from(presentation, { duration: 1, opacity: 0, y: 30, ease: "power2.out" }, '-=0.8');

      TL.play();
  } else {
      console.error("GSAP is not loaded.");
  }
});
