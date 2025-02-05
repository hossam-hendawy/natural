import barba from '@barba/core';
import gsap from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger';
import {headerBlock} from "../blocks/headerBlock";

gsap.registerPlugin(ScrollTrigger);

export function barbaInit() {
    document.body.setAttribute('data-barba', 'wrapper');
    console.log('Initializing Barba');

    function closeMobileMenu() {
        const headerSelector = document.querySelector('header');
        if (!headerSelector) return;

        const burgerMenu = headerSelector.querySelector('.burger-menu');
        const menuLinks = headerSelector.querySelector('.navbar');
        if (!burgerMenu) return;

        if (burgerMenu.classList.contains('burger-menu-active')) {
            burgerMenu.classList.remove('burger-menu-active');
            menuLinks.classList.remove('header-links-active');
            headerSelector.classList.remove('header-active');
            const burgerSpans = burgerMenu.querySelectorAll('span');
            gsap.timeline()
                .to(burgerSpans[0], {y: 0, rotation: 0, duration: 0.25}, 0)
                .to(burgerSpans[1], {autoAlpha: 1, duration: 0.25}, 0)
                .to(burgerSpans[2], {y: 0, rotation: 0, duration: 0.25}, 0);
        }
    }

    function hasHomeClass(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        return doc.body.classList.contains('home');
    }

    function hasInstitutionalClass(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        return doc.body.classList.contains('institutional');
    }

    barba.init({
        preventRunning: true,
        prevent: ({el}) => {
            // Prevent Barba from handling external links
            return el.href && el.href.startsWith('http') && !el.href.includes(window.location.hostname);
        },
        transitions: [{
            name: 'default-transition',
            beforeEnter(data) {
                const done = this.async();
                gsap.matchMedia().add("(min-width: 1024px)", () => {
                    gsap.set([document.documentElement, ...document.querySelectorAll('section')],
                        {overflow: 'hidden'});
                });
                closeMobileMenu();
                gsap.timeline()
                    .to(data.current.container, {
                        duration: 0.5,
                        autoAlpha: 0,
                        onComplete: () => {
                            gsap.set(data.next.container, {position: "fixed", inset: "0", zIndex: "-1"});
                            data.current.container.remove();

                            // Kill ScrollTriggers
                            let triggers = ScrollTrigger.getAll();
                            triggers.forEach(trigger => trigger.kill());

                            done();
                        }
                    })
            },
            enter(data) {
                gsap.set(data.next.container, {clearProps: 'all'});

                let parser = new DOMParser();
                let htmlDoc = parser.parseFromString(data.next.html, 'text/html');
                let newBodyClasses = htmlDoc.querySelector('body').classList;
                document.body.className = newBodyClasses.value;
            },
            afterEnter(data) {
                const done = this.async();
                gsap.timeline()
                    .set(data.next.container, {autoAlpha: 0})
                    .to(data.next.container, {
                        duration: 0.5,
                        autoAlpha: 1,
                        onComplete: () => {
                            done();
                            headerBlock();
                            gsap.matchMedia().add("(min-width: 1024px)", () => {
                                gsap.set([document.documentElement, ...document.querySelectorAll('section')],
                                    {delay: .5, overflow: 'auto'});
                            });
                        },
                    }, '-=.4')
            }
        }]
    });

    barba.hooks.beforeEnter(({next}) => {
        if (hasInstitutionalClass(next.html)) {
            const headerLinks = document.querySelectorAll(".header-link");
            headerLinks.forEach(link => {
                if (link.textContent.trim() === "Institutional") {
                    link.textContent = "Get in touch";
                    link.setAttribute("href", "mailto:welcome@map.io");
                }
            });
        }
        if (hasHomeClass(next.html)) {
            const headerLinks = document.querySelectorAll(".header-link");
            headerLinks.forEach(link => {
                if (link.textContent.trim() === "Get in touch") {
                    link.textContent = "Institutional";
                    link.setAttribute("href", "/institutional");
                }
            });
        }
    });

    // Add debug hooks
    barba.hooks.before(() => console.log('Before transition'));
    barba.hooks.after(() => console.log('After transition'));

    // Handle external links
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');

        if (link && link.href && link.href.startsWith('http')) {
            const linkHostname = new URL(link.href).hostname;
            const currentHostname = window.location.hostname;

            // Check if the link points to a different subdomain
            const isExternal = linkHostname !== currentHostname;

            if (isExternal) {
                e.preventDefault();

                if (link.target === '_blank') {
                    window.open(link.href, '_blank', 'noopener,noreferrer');
                } else {
                    window.location.href = link.href;
                }
            }
        }
    });

}