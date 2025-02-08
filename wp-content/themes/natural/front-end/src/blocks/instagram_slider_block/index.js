import './style.scss';
import Swiper from 'swiper';
import 'swiper/swiper.scss';
import { Autoplay } from 'swiper/modules';

export function instagram_slider_block() {
  const block = document.querySelector('.instagram_slider_block');
  if (!block) return;
  
  const swiper = new Swiper(block.querySelector('.instagram-slider'), {
    slidesPerView: "auto",
    spaceBetween: 10,
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
        spaceBetween: 20,
      },
    },
  
  });
}