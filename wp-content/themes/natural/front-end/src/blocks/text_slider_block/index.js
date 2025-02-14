import './style.scss';
import Swiper from 'swiper';
import 'swiper/swiper.scss';
import { Autoplay } from 'swiper/modules';

// The function to initialize the text slider
export function text_slider_block() {
  const block = document.querySelector('.text_slider_block');
  if (!block) return;

  const textSlider = block.querySelector('.text-slider');
  if (!textSlider) return;

  const wrapper = textSlider.querySelector('.text-slider-wrapper');
  if (!wrapper) return;

  // Get the speed from the data attribute (milliseconds for a full pass)
  const sliderSpeed = parseInt(textSlider.getAttribute('data-slider-speed'), 10) || 10000;

  // Capture the original slides
  const originalNodes = Array.from(wrapper.children);

  // Get the visible width of the slider container
  const sliderContainerWidth = textSlider.getBoundingClientRect().width;
  // Calculate the width of the original set of slides
  const originalWidth = wrapper.scrollWidth;

  // Clone the original slides until the total width is
  // at least (originalWidth + sliderContainerWidth)
  while (wrapper.scrollWidth < originalWidth + sliderContainerWidth) {
    originalNodes.forEach(node => {
      wrapper.appendChild(node.cloneNode(true));
    });
  }

  // We'll move from 0 to -originalWidth in "sliderSpeed" milliseconds.
  // Speed in px/ms:
  const pixelsPerMs = originalWidth / sliderSpeed;

  let translateX = 0;
  let lastTime = performance.now();
  let currentSpeed = pixelsPerMs; // this can be set to 0 on hover

  function moveSlides(currentTime) {
    // Time elapsed since last frame
    const deltaTime = currentTime - lastTime;
    lastTime = currentTime;

    // Move by the amount of pixels for this frame
    translateX -= currentSpeed * deltaTime;

    // If we've scrolled past one full set of original slides, reset.
    if (translateX <= -originalWidth) {
      translateX += originalWidth; // jump back by one set
    }

    wrapper.style.transform = `translateX(${translateX}px)`;

    requestAnimationFrame(moveSlides);
  }

  requestAnimationFrame(moveSlides);

  // Pause on hover (set speed to 0), resume on mouse leave
  textSlider.addEventListener('mouseenter', () => {
    currentSpeed = 0;
  });
  textSlider.addEventListener('mouseleave', () => {
    currentSpeed = pixelsPerMs;
  });
}
