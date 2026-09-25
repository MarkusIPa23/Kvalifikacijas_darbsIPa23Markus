

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll('[data-game-carousel]').forEach((carousel) => {
	const slides = [...carousel.querySelectorAll('.game-slide')];

	if (slides.length < 2) {
		return;
	}

	let activeIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));
	let rotationTimer;

	const showNextSlide = () => {
		slides[activeIndex].classList.remove('is-active');
		activeIndex = (activeIndex + 1) % slides.length;
		slides[activeIndex].classList.add('is-active');
	};

	const startRotation = () => {
		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			return;
		}

		window.clearInterval(rotationTimer);
		rotationTimer = window.setInterval(showNextSlide, 5000);
	};

	carousel.addEventListener('mouseenter', () => window.clearInterval(rotationTimer));
	carousel.addEventListener('mouseleave', startRotation);
	startRotation();
});
