import './bootstrap';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';

Alpine.plugin(mask);

document.addEventListener('livewire:load', () => {
    window.Alpine = Alpine;
    Alpine.start();
});
