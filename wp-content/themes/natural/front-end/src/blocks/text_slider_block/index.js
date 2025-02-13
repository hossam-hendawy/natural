import './style.scss';
import Swiper from 'swiper';
import 'swiper/swiper.scss';
import { Autoplay } from 'swiper/modules';

export function text_slider_block() {
  const block = document.querySelector('.text_slider_block');
  if (!block) return;

  const textSlider = block.querySelector('.text-slider');
  if (!textSlider) return;

  const wrapper = textSlider.querySelector('.text-slider-wrapper');
  if (!wrapper) return;

  // Capture the original slides before cloning
  const originalNodes = Array.from(wrapper.children);

  // Get the visible width of the slider container
  const sliderContainerWidth = textSlider.getBoundingClientRect().width;
  // Calculate the width of the original set of slides
  const originalWidth = wrapper.scrollWidth;

  // Clone the original nodes until the total width is at least (originalWidth + sliderContainerWidth)
  // This ensures that while scrolling one full set, there’s always a seamless follow-up.
  while (wrapper.scrollWidth < originalWidth + sliderContainerWidth) {
    originalNodes.forEach(node => {
      wrapper.appendChild(node.cloneNode(true));
    });
  }

  let speed = 3; // Movement speed per frame
  let translateX = 0;

  function moveSlides() {
    translateX -= speed;

    // When we've scrolled past one full set of original slides, reset.
    if (translateX <= -originalWidth) {
      translateX = 0;
    }

    wrapper.style.transform = `translateX(${translateX}px)`;
    requestAnimationFrame(moveSlides);
  }

  moveSlides();

  // Pause on hover and resume on mouse leave
  textSlider.addEventListener('mouseenter', () => {
    speed = 0;
  });
  textSlider.addEventListener('mouseleave', () => {
    speed = 3;
  });
}
