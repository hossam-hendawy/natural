//import blocks
import {headerBlock} from "./headerBlock";
import {footerBlock} from './footerBlock';
import {image_block} from './image_block';
import {home_here_block} from './home_here_block';
import {latest_news_block} from './latest_news_block';
import {who_we_are_block} from './who_we_are_block';
import {what_we_offer_block} from './what_we_offer_block';

export function indexBlocks() {
  headerBlock()
  footerBlock()
  image_block()
  home_here_block()
  latest_news_block()
  who_we_are_block()
  what_we_offer_block()
}

