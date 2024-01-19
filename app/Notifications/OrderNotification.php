<?php

namespace App\Notifications;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database',
            // 'mail'
        ];
    }

    public function toMail($notifiable)
    {
    }

    public function toArray($notifiable)
    {
        return [
            'order_id'      => $this->order->id,
            'order_code'    => $this->order->order_code,
            'status'        => $this->order->status,
        ];
    }
}
