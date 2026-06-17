import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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
