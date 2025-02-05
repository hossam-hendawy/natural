import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { debounce } from "./debounce";

gsap.registerPlugin(ScrollTrigger);

export function stickySidebar() {
    const sidebar = document.querySelector(".sticky-project-sidebar");
    const contentWrapper = document.querySelector(".right-content-wrapper");

    function initStickySidebar() {
        ScrollTrigger.getAll().forEach(trigger => trigger.kill());

        if (sidebar && contentWrapper && window.innerWidth > 1024) {
            ScrollTrigger.create({
                trigger: contentWrapper,
                start: "top 30px",
                end: "bottom bottom",
                pin: sidebar,
                pinSpacing: false,
            });
        }
    }

    const debouncedInit = debounce(initStickySidebar, 200);
    window.addEventListener("resize", debouncedInit);
    initStickySidebar();
}
