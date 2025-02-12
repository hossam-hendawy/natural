import './styles/index.scss';
import {indexBlocks} from './blocks/index-blocks';
import {initializeScrollSmoother} from "./scripts/scrollSmoother";


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
