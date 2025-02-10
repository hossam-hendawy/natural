//import blocks
import {headerBlock} from "./headerBlock";
import {footerBlock} from './footerBlock';
import {image_block} from './image_block';
import {home_here_block} from './home_here_block';
import {latest_news_block} from './latest_news_block';
import {who_we_are_block} from './who_we_are_block';
import {what_we_offer_block} from './what_we_offer_block';
import {how_we_do_it_block} from './how_we_do_it_block';
import {get_started_block} from './get_started_block';
import {instagram_slider_block} from './instagram_slider_block';
import {text_slider_block} from './text_slider_block';
import {three_images_and_text_block} from './three_images_and_text_block';

export function indexBlocks() {
  headerBlock()
  footerBlock()
  image_block()
  home_here_block()
  latest_news_block()
  who_we_are_block()
  what_we_offer_block()
  how_we_do_it_block()
  get_started_block()
  instagram_slider_block()
  text_slider_block()
  three_images_and_text_block()
}

