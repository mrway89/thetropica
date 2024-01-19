<?php

namespace App\Console\Commands;

use App\Events\Order\Payment\Pending;
use App\Order;
use App\OrderLog;
use App\NicepayCheckTransaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Libraries\NicepayLib;

class OrderChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check order and set to done';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $orders = Order::with('details', 'response')->where('status', ['pending', 'sent'])->get();

        // foreach ($orders as $order) {
        //     // 2 failed (jika pembayaran gagal; untuk virtual account/bank transfer dan convenience store -> jika tidak dibayar dalam 1x24 jam) vv
        //     if ($order->status == 'pending') {
        //         //
        //         if (Carbon::now() >= Carbon::parse($order->created_at)->addDays(1)) {
        //             $paymentStatus  = new NicepayLib;
        //             $paymentStatus = $paymentStatus->checkTransaction($order);

        //             $checkTransactionStatus = new NicepayCheckTransaction;
        //             $checkTransactionStatus->fill((array)$paymentStatus);
        //             $checkTransactionStatus->data = json_encode($paymentStatus);
        //             $checkTransactionStatus->save();
        //             $checkTransactionStatus->refresh();

        //             if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
        //                 $order->status         = 'paid';
        //                 $order->payment_date   = Carbon::parse($checkTransactionStatus->transDt . $checkTransactionStatus->transTm);
        //                 $order->payment_status = 1;
        //                 $order->save();
        //                 $order->refresh();

        //                 insertOrderLog($order, 'paid', 'cron');
        //             } else {
        //                 $order->setFailed();
        //                 $this->stockSync($order);
        //                 insertOrderLog($order, 'failed', 'cron');
        //             }
        //             event(new Pending($order));
        //         }
        //     }

        //     // 5 completed setelah barang dikirim  h+2
        //     if ($order->status == 'sent') {
        //         $track      = json_decode($this->rajaongkirTrack($order->no_resi, explode('-', $order->cart->courier_type_id)[0]));
        //         if ($track->rajaongkir->result->delivered) {
        //             $newOrder   = $this->saveOrder($order, 'completed');
        //             event(new Pending($newOrder));
        //         }
        //     }
        // }
    }

    protected function stockSync($order)
    {
        $myorder = Order::with('cart', 'cart.details', 'cart.details.product')->find($order->id);
        foreach ($myorder->cart->details as $item) {
            $item->product->stock += $item->qty;
            $item->product->save();
        }
    }

    protected function saveOrder($order, $status)
    {
        $order->status = $status;
        $order->save();

        $this->saveLog($order, $status);

        return $order;
    }

    protected function saveLog($order, $status)
    {
        $log                  = new OrderLog;
        $log->order_id        = $order->id;
        $log->status          = $status;
        $log->notes           = 'System update status to ' . ucwords($status);
        $log->admin_id        = 'System';
        $log->save();

        return;
    }

    protected function rajaongkirTrack($waybill, $courier)
    {
        $key = env('RAJAONGKIR_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://pro.rajaongkir.com/api/waybill',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => "waybill=$waybill&courier=$courier",
            CURLOPT_HTTPHEADER     => ['content-type: application/x-www-form-urlencoded', "key: $key"],
        ]);

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }
}
