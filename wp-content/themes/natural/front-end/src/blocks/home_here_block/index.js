import './style.scss';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function home_here_block() {
  let tl; // Declare timeline variable globally for cleanup
  let isActive = false; // Track if animation is active

  function initAnimations() {
    if (window.innerWidth <= 1024 || isActive) return; // Prevent reinitialization
    isActive = true;

    const homeHero = document.querySelector('.home_here_block');
    const logo = document.querySelector('.main-logo');
    const navbar = document.querySelector('.navbar');
    const burgerMenu = document.querySelector('.burger-menu');
    const video = homeHero?.querySelector('.media-wrapper video');
    const videoWrapper = homeHero?.querySelector('.media-wrapper');
    const content = homeHero?.querySelector('.content-wrapper');

    if (!homeHero || !logo || !navbar || !video || !content) return;

    tl = gsap.timeline({
      scrollTrigger: {
        trigger: homeHero,
        start: 'top top',
        end: 'bottom bottom',
        scrub: true,
        pinSpacing: false,
        pin: videoWrapper
      }
    });

    tl.to(logo, {
      scale: 0.7,
      duration: 2,
      transformOrigin: 'top left',
    }, 0);

    tl.to(logo, {
      y: "-120%",
      duration: 2,
    }, 2);

    tl.to([navbar, burgerMenu], {
      opacity: 0,
      duration: 0.1,
    }, 0);

    tl.to(video, {
      height: '100vh',
      width: '100%',
      top: 0,
      borderRadius:0,
      duration: 2,
    }, 0);
  }

  function destroyAnimations() {
    if (tl) {
      tl.kill();
      ScrollTrigger.getAll().forEach(trigger => trigger.kill());

      // Restore the logo and burger menu visibility
      const logo = document.querySelector('.main-logo');
      const navbar = document.querySelector('.navbar');
      const burgerMenu = document.querySelector('.burger-menu');
      const videoWrapper = document.querySelector('.media-wrapper');

      if (logo) {
        gsap.set(logo, { opacity: 1, scale: 1, y: 0 });
      }
      if (navbar) {
        gsap.set(navbar, { opacity: 1 });
      }
      if (burgerMenu) {
        gsap.set(burgerMenu, { opacity: 1 });
      }

      // Remove leftover GSAP pin-spacers
      document.querySelectorAll('.pin-spacer').forEach(spacer => {
        spacer.replaceWith(...spacer.childNodes); // Unwrap the elements from the spacer
      });

      // Reset styles on the pinned elements
      if (videoWrapper) {
        gsap.set(videoWrapper, { clearProps: 'all' }); // Reset all GSAP-applied styles
      }
    }
    isActive = false;
  }


  function handleResize() {
    if (window.innerWidth > 1024) {
      initAnimations();
    } else {
      destroyAnimations();
    }
  }

  initAnimations()

  // Listen for window resize events
  window.addEventListener('resize', handleResize);
}
