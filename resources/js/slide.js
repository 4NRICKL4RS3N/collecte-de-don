import '@splidejs/splide/dist/js/splide.js';
import Splide from '@splidejs/splide';

document.addEventListener( 'DOMContentLoaded', function() {
    var splide = new Splide( '.splide', {
        type   : 'loop',
        perPage: 3,
        perMove: 1,
        gap: '1rem',
        breakpoints: {
            769: { perPage: 1, gap: '0.5rem' },
            992: { perPage: 2, gap: '0.5rem' },
        },
    } );

    splide.mount();
} );
