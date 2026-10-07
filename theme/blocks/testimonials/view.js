import Swiper from 'swiper';
import { A11y, Keyboard, Navigation } from 'swiper/modules';

document.querySelectorAll( '.testimonials' ).forEach( ( section ) => {
	const slider = section.querySelector( '.testimonials__slider' );

	if ( ! slider ) {
		return;
	}

	new Swiper( slider, {
		modules: [ A11y, Keyboard, Navigation ],
		slidesPerView: 1,
		spaceBetween: 32,
		keyboard: { enabled: true },
		navigation: {
			prevEl: section.querySelector( '.testimonials__arrow--prev' ),
			nextEl: section.querySelector( '.testimonials__arrow--next' ),
		},
	} );
} );
