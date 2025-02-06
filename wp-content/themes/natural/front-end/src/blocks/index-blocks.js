//import blocks
import {headerBlock} from "./headerBlock";
import {footerBlock} from './footerBlock';
import {image_block} from './image_block';
import {home_here_block} from './home_here_block';
import {latest_news_block} from './latest_news_block';
import {image_and_text_block} from './image_and_text_block';

export function indexBlocks() {
  headerBlock()
  footerBlock()
  image_block()
  home_here_block()
  latest_news_block()
  image_and_text_block()
}

