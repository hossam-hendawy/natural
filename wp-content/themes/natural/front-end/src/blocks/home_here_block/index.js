import './style.scss';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function home_here_block() {
  const homeHero = document.querySelector('.home_here_block');
  const logo = document.querySelector('.main-logo');
  const navbar = document.querySelector('.navbar');
  const burgerMenu = document.querySelector('.burger-menu');
  const video = homeHero.querySelector('.media-wrapper video');
  const videoWrapper = homeHero.querySelector('.media-wrapper ');
  const content = homeHero.querySelector('.content-wrapper');  // Select the content wrapper for text

  if (!homeHero || !logo || !navbar || !video || !content) return;

  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: homeHero,
      start: 'top top',
      end: 'bottom bottom',
      scrub: true,
      pinSpacing: true,
      pin: videoWrapper
    }
  });

  // Scale the logo and move it up
  tl.to(logo, {
    scale: 0.7,
    duration:4,
    transformOrigin: 'top left',
  }, 0);

  tl.to(logo, {
    y: "-200%",
    duration:2,
  }, 3);

  // Hide the navbar
  tl.to([navbar, burgerMenu], {
    opacity: 0,
    duration: 0.1,
  }, 0);

  // Scale the video to full size
  tl.to(video, {
    height: '100vh',
    width: '100%',
    top:0,
    duration: 3,
  }, 0);

  // tl.fromTo(content,
  //     { y: 100 },  // Start with text hidden and slightly below
  //     {y: 0, duration: 3},
  // );

  // Pin the video until the entire hero section scrolls out of view
  // ScrollTrigger.create({
  //   trigger: homeHero,
  //   start: 'top top',
  //   end: 'bottom top',
  //   pin: video,
  //   pinSpacing: true,
  //   scrub: true,
  // });
}
