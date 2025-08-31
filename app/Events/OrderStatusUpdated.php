<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $order_id;
    public $status;
    public $customer_id;
    public $customer_name;

    /**
     * Create a new event instance.
     */
    public function __construct($orderId, $status)
    {
        $this->order_id = $orderId;
        $this->status = $status;

        $order = Order::with('user')->findOrFail($orderId);
        $this->customer_id = $order->user_id;
        $this->customer_name = $order->user->name;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return new PrivateChannel('orders.' . $this->customer_id);
    }

    /**
     * Event name for the frontend
     */
    public function broadcastAs(): string
    {
        return 'OrderStatusUpdated';
    }
}
