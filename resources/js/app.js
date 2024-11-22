import './bootstrap';

//Masmerise Livewire-Toaster
import '../../vendor/masmerise/livewire-toaster/resources/js';

//Flowbite
import 'flowbite';

//PowerGrid
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';
import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css';

document.addEventListener('livewire:navigated', () => {
    initFlowbite();
})
