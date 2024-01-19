<?php
namespace App\Service;

class PurchaseLimitService
{
    public static function availableQty($user_id, $product_id)
    {
        $product = \App\Product::find($product_id);
        if (!empty($product->purchase_limit_days) && $product->purchase_limit_qty) {
            $day_ago = $product->purchase_limit_days - 1;
            $date_ago = date('Y-m-d', strtotime('-'.$day_ago.' days', strtotime(date('Y-m-d'))));

            $order = \App\OrderDetail::SelectRaw(
                "order_details.*, orders.created_at as order_date"
            )->join(
                "orders", "orders.id", "=", "order_details.order_id"
            )->where([
                ["order_details.product_id", $product_id],
                ["orders.user_id", $user_id],
            ])->where([
                ["orders.created_at", ">=", $date_ago]
            ])->get();

            $total_purchased_qty = 0;
            foreach ($order as $o) {
                $total_purchased_qty += $o->quantity;
            }

            $qty_available = $product->purchase_limit_qty - $total_purchased_qty;
            return $qty_available;
        }

        return $product->stock;
    }
}