import './style.scss';
import {gsap} from "gsap";


export function headerBlock() {
  const header = document.querySelector('header');
  if (!header) return;
  
  const burgerMenu = header.querySelector('.burger-menu');
  const menuLinks = header.querySelector('.navbar');
  
  
  if (!burgerMenu) return;
  const burgerTl = gsap.timeline({paused: true});
  const burgerSpans = burgerMenu.querySelectorAll('div');
  gsap.set(burgerSpans, {transformOrigin: 'center'});
  burgerTl
      .to(burgerSpans, {
        y: gsap.utils.wrap([`0.6rem`, 0, `-0.6rem`]),
        duration: 0.25,
      })
      .set(burgerSpans, {autoAlpha: gsap.utils.wrap([1, 0, 1])})
      .to(burgerSpans, {rotation: gsap.utils.wrap([45, 0, -45])})
      .set(burgerSpans, {rotation: gsap.utils.wrap([45, 0, 135])});
  burgerMenu.addEventListener('click', function () {
    if (burgerMenu.classList.contains('burger-menu-active')) {
      // region allow page scroll
      document.documentElement.classList.remove('modal-opened');
      // endregion allow page scroll
      burgerMenu.classList.remove('burger-menu-active');
      menuLinks.classList.remove('header-links-active');
      header.classList.remove('header-active');
      burgerTl.reverse();
    } else {
      burgerMenu.classList.add('burger-menu-active');
      menuLinks.classList.add('header-links-active');
      header.classList.add('header-active');
      burgerTl.play();
      // region prevent page scroll
      document.documentElement.classList.add('modal-opened');
      // endregion prevent page scroll
      gsap.fromTo(menuLinks.querySelectorAll('.menu-item , .bottom-content'), {
        y: 30,
        autoAlpha: 0,
      }, {
        y: 0,
        autoAlpha: 1,
        stagger: .05,
        duration: .4,
        delay: .5,
      });
    }
  });
  
  // region open sub menu in responsive
  const menuItems = header.querySelectorAll('.menu-item-has-children');
  const mobileMedia = window.matchMedia('(max-width: 992px)');
  menuItems.forEach((menuItem) => {
    const menuItemBody = menuItem.querySelector('.sub-menu');
    menuItem?.addEventListener('click', (e) => {
      
      if (!mobileMedia.matches || !menuItemBody || e.target.classList.contains('header-link') || e.target.closest('.sub-menu,.menu-item-in-sub-menu a')) return;
      const isOpened = menuItem?.classList.toggle('menu-item-active');
      if (!isOpened) {
        gsap.to(menuItemBody, {height: 0});
      } else {
        gsap.to(Array.from(menuItems).map(otherMenuItem => {
          const otherMenuItemBody = otherMenuItem.querySelector('.sub-menu');
          if (otherMenuItemBody && menuItem !== otherMenuItem) {
            otherMenuItem?.classList.remove('menu-item-active');
            gsap.set(otherMenuItem, {zIndex: 1});
          }
          return otherMenuItemBody;
        }), {height: 0});
        gsap.set(menuItem, {zIndex: 2});
        gsap.to(menuItemBody, {height: 'auto'});
      }
    });
  });
  
  
  // endregion open sub menu in responsive
  
}

