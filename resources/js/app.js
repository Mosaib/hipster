import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (window.Laravel.userId) {
    window.Echo.private(`orders.${window.Laravel.userId}`)
        .listen('.OrderStatusUpdated', (e) => {
            console.log('Received event', e);
            alert(`Order #${e.order_id} for ${e.customer_name} status is now: ${e.status}`);
        });
}
