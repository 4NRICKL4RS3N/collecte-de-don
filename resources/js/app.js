import 'bootstrap';
import './bootstrap';
import PhotoSwipeLightbox from 'photoswipe/lightbox';
import PhotoSwipe from 'photoswipe';
import 'photoswipe/style.css';

// project gallery
const lightbox = new PhotoSwipeLightbox({
    gallery: '#project-gallery',
    children: 'a',
    showHideAnimationType: 'zoom',
    pswpModule: () => import('photoswipe')
});
lightbox.init();
