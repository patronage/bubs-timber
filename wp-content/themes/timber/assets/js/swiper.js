import { register } from 'swiper/element/bundle';
import { Navigation, Pagination } from 'swiper/modules';

import { logMessage } from './console';

logMessage('you are in swiper.js');

register();

const swiperEl = document.querySelector('swiper-container');

const params = {
  modules: [Navigation, Pagination],
  // inject modules styles to shadow DOM
  injectStylesUrls: [
    'https://cdn.jsdelivr.net/npm/swiper@10/modules/navigation-element.min.css',
    'https://cdn.jsdelivr.net/npm/swiper@10/modules/pagination-element.min.css',
  ],
};

Object.assign(swiperEl, params);

swiperEl.initialize();
