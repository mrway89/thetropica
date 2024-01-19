<?php

namespace App\Http\ViewComposers;

use App\Cart;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // shopping cart list
        $data = null;
        if (\Auth::check()) {
            $data['carts'] = Cart::with('details', 'details.product', 'details.product.cover', 'details.product.brand')->where('status', 'current')->where('type', '=', 'cart')->where('user_id', \Auth::id())->first();
        }
        $view->with($data);
    }
}
