import gsap from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger';
import {ScrollSmoother} from 'gsap/ScrollSmoother';
import {ScrollToPlugin} from 'gsap/ScrollToPlugin';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother, ScrollToPlugin);

export function initializeScrollSmoother() {
    // Check if device is desktop (width > 1024px)
    const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
    setTimeout(() => {
        // Only proceed if on desktop
        if (isDesktop) {
            // Kill any existing ScrollSmoother instance
            let smoother = ScrollSmoother.get();
            if (smoother) {
                smoother.kill();
            }

            // Create new ScrollSmoother instance
            smoother = ScrollSmoother.create({
                smooth: 2,
                effects: true,
            });

            // Handle smooth scrolling for hash links
            document.querySelectorAll('a[href^="#"]').forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        smoother.scrollTo(targetElement, true, "top top");
                    }
                });
            });

            // Handle initial hash on load
            if (window.location.hash) {
                const targetElement = document.querySelector(window.location.hash);
                if (targetElement) {
                    smoother.scrollTo(targetElement, true, "top top");
                }
            }

            ScrollTrigger.refresh();
        }
    }, 200);

}