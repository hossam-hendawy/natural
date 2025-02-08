import './style.scss';
import Swiper from 'swiper';
import 'swiper/swiper.scss';
import { Autoplay } from 'swiper/modules';

export function text_slider_block() {
  const block = document.querySelector('.text_slider_block');
  if (!block) return;
  
  const swiper = new Swiper(block.querySelector('.text-slider'), {
    slidesPerView: "auto",
    spaceBetween: 22,
    loop: true,
    modules: [Autoplay],
    speed: 5000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    breakpoints: {
      1024: {
        spaceBetween: 50,
      },
    },
  
  });
}