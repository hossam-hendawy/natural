import '../three_images_and_text_block/style.scss';
import Swiper from 'swiper';
import 'swiper/swiper.scss';
import 'swiper/modules/navigation.scss';

export function three_images_and_text_block() {
  const block = document.querySelector('.three_images_and_text_block');
  if (!block) return;
  
  
  const swiper = new Swiper(block.querySelector('.swiper-images'), {
    slidesPerView: 'auto',
    spaceBetween: 20,
    loop: true,
  });
}

