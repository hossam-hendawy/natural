import './style.scss';
import {gsap} from "gsap";


export function headerBlock() {
  const header = document.querySelector('header');
  if (!header) return;
  
  const burgerMenu = header.querySelector('.burger-menu');
  const menuLinks = header.querySelector('.navbar');
  
  
  if (!burgerMenu) return;
  const burgerTl = gsap.timeline({paused: true});
  const burgerSpans = burgerMenu.querySelectorAll('span');
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
      gsap.fromTo(menuLinks.querySelectorAll('.menu-item'), {
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
  
  // handel open the taxonomy sub menu in mobile
  const taxNameArrows = header.querySelectorAll('.tax-name-and-arrow');
  
  taxNameArrows.forEach((el) => {
    el.addEventListener('click', (e) => {
      e.stopPropagation();
      const innerSubMenu = el.nextElementSibling;
      
      if (!innerSubMenu) return;
      
      const isOpened = innerSubMenu.classList.toggle('open');
      if (!isOpened) {
        gsap.to(innerSubMenu, {height: 0});
        el.classList.remove('active')
      } else {
        gsap.to(innerSubMenu, {height: 'auto'});
        el.classList.add('active')
      }
    });
  });
  
  // endregion
  
  function addActiveClass(el) {
    el.classList.toggle('active');
    checkBothActive();
  }
  
  function checkBothActive() {
    if (activeStatus.classList.contains('active') && realizedStatus.classList.contains('active')) {
      mainSelect.classList.add('active');
      
    } else {
      mainSelect.classList.remove('active');
    }
  }
  
  const mainSelect = header.querySelector('.main-select');
  const activeStatus = header.querySelector('.active-statues');
  const realizedStatus = header.querySelector('.realized-statues');
  
  if (mainSelect) {
    mainSelect.addEventListener('click', () => {
      mainSelect.classList.toggle('active');
      activeStatus.classList.toggle('active');
      realizedStatus.classList.toggle('active');
      if (activeStatus.classList.contains('active') || realizedStatus.classList.contains('active')) {
        activeStatus.classList.add('active');
        realizedStatus.classList.add('active');
      }
    });
  }
  
  activeStatus.addEventListener('click', () => {
    addActiveClass(activeStatus);
  });
  
  realizedStatus.addEventListener('click', () => {
    addActiveClass(realizedStatus);
  });
  
  
  function handleSelectAll(selectAllClass, itemsContainerClass, header) {
    const selectAll = header.querySelector(`.${selectAllClass}`);
    const items = header.querySelectorAll(`.${itemsContainerClass} .box-wrapper:not(.${selectAllClass})`);
    
    selectAll.addEventListener("click", () => {
      const isActive = selectAll.classList.toggle("active");
      items.forEach(item => item.classList.toggle("active", isActive));
      updateSelectedFilters();
    });
    
    items.forEach(item => {
      item.addEventListener("click", () => {
        item.classList.toggle("active");
        const allSelected = [...items].every(el => el.classList.contains("active"));
        selectAll.classList.toggle("active", allSelected);
        updateSelectedFilters();
      });
    });
  }
  
  function updateSelectedFilters() {
    const selectedIndustries = getSelectedFilters("industries-sub-menu");
    const selectedYears = getSelectedFilters("years-sub-menu");
    
    console.log("Selected Industries:", selectedIndustries);
    console.log("Selected Years:", selectedYears);
  }
  
  function getSelectedFilters(containerClass) {
    const selectedItems = header.querySelectorAll(`.${containerClass} .box-wrapper.active`);
    return Array.from(selectedItems).map(item => ({
      taxonomy: item.getAttribute("data-taxonomy"),
      termId: item.getAttribute("data-term-id")
    }));
  }
  
  
  handleSelectAll("select-all-industries", "industries-sub-menu", header);
  handleSelectAll("select-all-years", "years-sub-menu", header);
  
  // region old code
  // // region Select All Industries
  // const selectAll = header.querySelector(".select-all-industries");
  // const industryItems = header.querySelectorAll(".industries-sub-menu .box-wrapper:not(.select-all-industries)");
  //
  //
  // selectAll.addEventListener("click", () => {
  //   const isActive = selectAll.classList.contains("active");
  //
  //   if (isActive) {
  //     selectAll.classList.remove("active");
  //     industryItems.forEach(item => item.classList.remove("active"));
  //   } else {
  //     selectAll.classList.add("active");
  //     industryItems.forEach(item => item.classList.add("active"));
  //   }
  // });
  //
  // industryItems.forEach(item => {
  //   item.addEventListener("click", () => {
  //     item.classList.toggle("active");
  //
  //     // Check if all are active
  //     const allSelected = [...industryItems].every(el => el.classList.contains("active"));
  //     if (allSelected) {
  //       selectAll.classList.add("active");
  //     } else {
  //       selectAll.classList.remove("active");
  //     }
  //   });
  // });
  // // endregion

//   // region Select All Years
//   const selectAllYears = header.querySelector(".select-all-years");
//   const yearItems = header.querySelectorAll(".years-sub-menu .box-wrapper:not(.select-all-years)");
//   console.log(selectAllYears)
//   selectAllYears.addEventListener("click", () => {
//     const isActive = selectAllYears.classList.contains("active");
//
//     if (isActive) {
//       selectAllYears.classList.remove("active");
//       yearItems.forEach(item => item.classList.remove("active"));
//     } else {
//       selectAllYears.classList.add("active");
//       yearItems.forEach(item => item.classList.add("active"));
//     }
//   });
//
//   yearItems.forEach(item => {
//     item.addEventListener("click", () => {
//       item.classList.toggle("active");
//
//       // Check if all year items are selected
//       const allSelected = [...yearItems].every(el => el.classList.contains("active"));
//       if (allSelected) {
//         selectAllYears.classList.add("active");
//       } else {
//         selectAllYears.classList.remove("active");
//       }
//     });
//   });
// //   endregion
//   endregion
}

