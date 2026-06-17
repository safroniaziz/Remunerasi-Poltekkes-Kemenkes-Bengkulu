import './bootstrap';

import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Expose AOS so Blade inline scripts & legacy files can use it safely.
window.AOS = AOS;

// Alpine `x-data="{ switcher: translationSwitcher() }"` is used on several
// public pages. Define it here (bundled) so it is always available before
// Alpine starts, regardless of legacy script load order/caching.
if (localStorage.getItem('language-storage') === null) {
    localStorage.setItem('language-storage', 0);
}

window.translationSwitcher = function () {
    return {
        selected: localStorage.getItem('language-storage'),
        countries: [
            { label: 'Indonesia', lang: 'id', flag: 'id' },
        ],
        menuToggle: false,
    };
};

window.Alpine = Alpine;

Alpine.start();

const initAos = () => AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true });
if (document.readyState !== 'loading') {
    initAos();
} else {
    document.addEventListener('DOMContentLoaded', initAos);
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-modal-toggle]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const modalId = trigger.getAttribute('data-modal-target') || trigger.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);

            if (!modal) {
                return;
            }

            modal.classList.toggle('hidden');
            modal.setAttribute('aria-hidden', modal.classList.contains('hidden') ? 'true' : 'false');
        });
    });

    document.querySelectorAll('[data-modal-hide]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const modal = document.getElementById(trigger.getAttribute('data-modal-hide'));

            if (!modal) {
                return;
            }

            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
        });
    });
});
