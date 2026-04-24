const getElement = (selector) => document.querySelector(selector);
const getElements = (selector) => Array.from(document.querySelectorAll(selector));

const setDarkMode = (enabled, checkbox) => {
    document.documentElement.classList.toggle('dark', enabled);
    localStorage.setItem('darkMode', enabled ? 'true' : 'false');

    if (checkbox) {
        checkbox.checked = enabled;
    }
};

const initDarkMode = () => {
    const darkModeButton = getElement('#dark-mode-button');
    const darkModeCheckbox = getElement('#dark-mode-checkbox');
    const prefersDark = localStorage.getItem('darkMode') === 'true';

    setDarkMode(prefersDark, darkModeCheckbox);

    if (darkModeButton) {
        darkModeButton.addEventListener('click', () => {
            const isDark = !document.documentElement.classList.contains('dark');
            setDarkMode(isDark, darkModeCheckbox);
        });
    }

    if (darkModeCheckbox) {
        darkModeCheckbox.addEventListener('change', (event) => {
            setDarkMode(event.target.checked, darkModeCheckbox);
        });
    }
};

const initSwipers = () => {
    if (typeof Swiper === 'undefined') {
        return;
    }

    if (getElement('.single-swiper-slider')) {
        new Swiper('.single-swiper-slider', {
            spaceBetween: 20,
            slidesPerView: 1,
            loop: true,
            effect: 'creative',
            creativeEffect: {
                prev: {
                    shadow: true,
                    translate: [0, 0, -400],
                },
                next: {
                    translate: ['100%', 0, 0],
                },
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
            },
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
        });
    }

    if (getElement('.col3-swiper-slider')) {
        new Swiper('.col3-swiper-slider', {
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                992: { slidesPerView: 3 },
                576: { slidesPerView: 2 },
                0: { slidesPerView: 1 },
            },
        });
    }

    if (getElement('.col4-swiper-slider')) {
        new Swiper('.col4-swiper-slider', {
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                992: { slidesPerView: 4 },
                768: { slidesPerView: 3 },
                480: { slidesPerView: 2 },
                0: { slidesPerView: 1 },
            },
        });
    }

    if (getElement('.auto-swiper-slider')) {
        new Swiper('.auto-swiper-slider', {
            slidesPerView: 'auto',
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }

    if (getElement('.card-swiper-slider')) {
        new Swiper('.card-swiper-slider', {
            effect: 'cards',
            grabCursor: true,
            autoplay: {
                delay: 3000,
            },
            cardsEffect: {
                rotate: 50,
                slideShadows: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
};

const initPlyr = () => {
    if (typeof Plyr === 'undefined') {
        return;
    }

    getElements('.js-player').forEach((player) => {
        if (player.dataset.plyrReady === 'true') {
            return;
        }

        player.dataset.plyrReady = 'true';

        new Plyr(player, {
            controls: [
                'play-large',
                'play',
                'progress',
                'current-time',
                'mute',
                'volume',
                'settings',
                'fullscreen',
            ],
        });
    });
};

const initScrollToTop = () => {
    const scrollToTopBtn = getElement('#scrollToTopBtn');

    if (!scrollToTopBtn) {
        return;
    }

    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
};

const buildCopyButton = () => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'code-copy-button';
    button.textContent = 'کپی';

    return button;
};

const initCodeBlocks = () => {
    getElements('.article-content pre').forEach((block) => {
        if (block.parentElement?.classList.contains('code-block-wrapper')) {
            return;
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'code-block-wrapper';
        block.parentNode.insertBefore(wrapper, block);
        wrapper.appendChild(block);

        const button = buildCopyButton();
        wrapper.appendChild(button);

        button.addEventListener('click', async () => {
            const text = block.innerText;

            try {
                await navigator.clipboard.writeText(text);
                button.textContent = 'کپی شد';
                window.setTimeout(() => {
                    button.textContent = 'کپی';
                }, 1800);
            } catch (error) {
                button.textContent = 'ناموفق';
                window.setTimeout(() => {
                    button.textContent = 'کپی';
                }, 1800);
                console.error('Copy failed:', error);
            }
        });
    });
};

const initFrontend = () => {
    initDarkMode();
    initSwipers();
    initPlyr();
    initScrollToTop();
    initCodeBlocks();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFrontend);
} else {
    initFrontend();
}
