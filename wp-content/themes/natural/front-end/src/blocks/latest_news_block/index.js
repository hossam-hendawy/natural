import './style.scss';
import Swiper from 'swiper';
import 'swiper/swiper.scss';
import 'swiper/modules/navigation.scss';
import {Navigation} from 'swiper/modules';

export function latest_news_block() {
  const block = document.querySelector('.latest_news_block');
  if (!block) return;
  
  
  const swiper = new Swiper(block.querySelector('.recent-projects-Swiper'), {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    modules: [Navigation],
    breakpoints: {
      600: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      1280: {
        slidesPerView: 3,
        spaceBetween: 40,
      },
    },
    navigation: {
      nextEl: block.querySelector(".swiper-button-next"),
      prevEl: block.querySelector(".swiper-button-prev"),
    },
  });
}