import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {indexBlocks} from "../blocks/index-blocks";

gsap.registerPlugin(ScrollTrigger);

export function reinitializeScripts() {
    indexBlocks()
    ScrollTrigger.refresh();
}