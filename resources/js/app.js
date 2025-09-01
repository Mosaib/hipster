import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (window.Laravel.userId) {
    window.Echo.private(`orders.${window.Laravel.userId}`)
        .listen('.OrderStatusUpdated', (e) => {
            console.log('Received event', e);
            alert(`Dear ${e.customer_name} your Order #${e.order_id} has been updated: ${e.status}`);
        });
}