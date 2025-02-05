import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

gsap.config({
    nullTargetWarn: false,
    trialWarn: false,
    force3D: true,
});

gsap.defaults({
    overwrite: 'auto',
    ease: 'power2.out',
});

export function generalPageAnimation() {
    const animatedElements = document.querySelectorAll(
        '.animation-fade-me-up, .animation-scale-me, .animation-move-me-right, .animation-move-me-left'
    );
    if (animatedElements.length) {
        gsap.set(animatedElements, { opacity: 0 });

        ScrollTrigger.batch(animatedElements, {
            onEnter: (batch) => {
                batch.forEach((element) => {
                    let vars = { opacity: 1, duration: 0.9 };
                    if (element.classList.contains('animation-fade-me-up-paused')) {
                        vars.y = 0;
                        vars.stagger = 0.2;
                        gsap.fromTo(element, { y: 100 }, vars);
                    } else if (element.classList.contains('animation-scale-me')) {
                        vars.autoAlpha = 1;
                        gsap.fromTo(element, { autoAlpha: 0 }, vars);
                    } else if (element.classList.contains('animation-move-me-right-paused')) {
                        vars.x = 0;
                        gsap.fromTo(element, { x: 100 }, vars);
                    } else if (element.classList.contains('animation-move-me-left-paused')) {
                        vars.x = 0;
                        gsap.fromTo(element, { x: -100 }, vars);
                    } else {
                        gsap.to(element, vars);
                    }
                });
            },
            start: 'top 70%',
            once: true,
        });
    }

    // Handle door-open-left and door-open-right together with scroll-linked animations
    const sections = document.querySelectorAll('.door-section-paused'); // Ensure each section has this class

    sections.forEach((section) => {
        const leftDoor = section.querySelector('.door-open-left');
        const rightDoor = section.querySelector('.door-open-right');

        if (leftDoor && rightDoor) {
            // Set initial positions
            gsap.set(leftDoor, { x: -100 });
            gsap.set(rightDoor, { x: 100 });

            // Create a timeline for synchronized animations
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: section,
                    start: 'top center',
                    end: 'bottom center',
                    scrub: true,
                },
            });

            tl.to(leftDoor, { x: 0, duration: 1 }, 0)
                .to(rightDoor, { x: 0, duration: 1 }, 0);
        }
    });
}
