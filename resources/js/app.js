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
    pswpModule: PhotoSwipe,
    allowPanToNext: false,
    allowMouseDrag: false,
});
lightbox.on('contentLoad', (e) => {
    const { content, isLazy } = e;

    if (content.data.element.dataset.pswpType === 'video') {
        content.element = document.createElement('div');
        content.element.className = 'pswp__video-container';

        const videoElement = document.createElement('video');
        videoElement.src = content.data.src;
        videoElement.controls = true;
        videoElement.autoplay = false;

        content.element.appendChild(videoElement);

        content.state = 'loaded';

        if (isLazy) {
            e.preventDefault();
        }
    }
});

lightbox.on('change', () => {
    const videos = lightbox.pswp.container.querySelectorAll('video');
    videos.forEach(video => video.pause());
});

lightbox.init();
