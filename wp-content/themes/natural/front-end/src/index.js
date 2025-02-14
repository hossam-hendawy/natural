import './styles/index.scss';
import {indexBlocks} from './blocks/index-blocks';
import {initializeScrollSmoother} from "./scripts/scrollSmoother";
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);


window.addEventListener('load', async function () {
  indexBlocks();
  initializeScrollSmoother();
  setTimeout(() => {
    document.body.classList.add('loaded');
  }, 200);
});

window.addEventListener('resize', () => {
  ScrollTrigger.refresh();
});
