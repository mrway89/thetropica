<?php

namespace App\Mail\Order\Payment;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\NicepayEnterpriseRegistrationResponse;

class PendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $type;

    public function __construct($order, $type)
    {
        $this->order = $order;
        $this->type  = $type;
    }

    public function build()
    {
        if ($this->order->status == 'pending') {
            $emailTitle = 'The Tropical Spa: New Order #' . $this->order->order_code;
        }

        if ($this->order->status == 'paid') {
            $emailTitle = 'The Tropical Spa: Order #' . $this->order->order_code . ' is on Process';
        }

        if ($this->order->status == 'sent') {
            $emailTitle = 'The Tropical Spa: Order #' . $this->order->order_code . ' is on Delivery';
        }

        if ($this->order->status == 'completed') {
            $emailTitle = 'The Tropical Spa: Order #' . $this->order->order_code . ' is Completed';
        }

        if ($this->order->status == 'failed') {
            $emailTitle = 'The Tropical Spa: Order #' . $this->order->order_code . ' is Failed';
        }

        if ($this->type == 'user' && $this->order->status == 'pending') {

            $paymentInstruction = Post::where('type', 'permata')->get();

            $data['instructions']     = $paymentInstruction;
        }

        $data['order']     = $this->order;
        $data['type']      = $this->type;

        $data['title']     = 'Order #' . $this->order->order_code;

        return $this->subject($emailTitle)->view('email/order/new_order', $data);
    }
}
