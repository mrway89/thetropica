<?php

namespace App\Http\Controllers\Frontend;

use App\Article;
use App\Cart;
use App\Category;
use App\Events\Order\Payment\Pending;
use App\Image;
use App\Libraries\NicepayLib;
use App\Order;
use App\Popup;
use App\Product;
use App\User;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        // REFERRAL
        if ($request->ref) {
            session()->forget('referral_code');
            $id   = preg_replace('/[^0-9,.]/', '', $request->ref);
            $user = User::find($id);

            if ($user) {
                session(['referral_code' => $request->ref]);
            }
        }

        $today      = \Carbon\Carbon::now();
        $slideshow  = Image::where('type', 'home_slideshow')->orderByRaw('RAND()')->get();
        $about      = Image::where('type', 'home_banner');
        $origin     = Image::where('type', 'home_origin');
        $product    = Image::where('type', 'home_product');
		 $products  = Product::with('review', 'cover')->where('is_active', 1);
        $popup      = Popup::whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today);

        // $banners    = Image::where('type', 'home_banner')->get();
        // $categories = Category::with('homeProducts', 'homeProducts.product', 'homeProducts.product.cover')->where('parent_id', 0)->where('is_featured', 1)->get();
        // ->where('is_featured', 1)

        $this->data['slideshow']  = $slideshow;
        $this->data['about']      = $this->cacheQuery('home_about', $about, 'first');
        $this->data['origin']     = $this->cacheQuery('home_origin', $origin, 'first');
        $this->data['product']    = $this->cacheQuery('home_product', $product, 'first');
        $this->data['popup']      = $this->cacheQuery('home_popup', $popup, 'first');
        // $this->data['banners']    = $banners;
        // $this->data['categories'] = $categories;
		
		//$slider_produk = DB::select("select * from `products` where `is_active` = '1' order by `sorting` asc limit 4 offset 0");
        //$this->data['list_slider_produk']       = $slider_produk;
		
		$this->data['list_slider_produk'] = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
        // SEO
        $this->data['head_title']       = $this->data['home_title'];
        $this->data['head_meta_title']  = $this->data['home_meta_title'];
        $this->data['head_description'] = $this->data['home_description'];
        $this->data['head_keyword']     = $this->data['home_keywords'];

        return $this->renderView('frontend.index');
    }

    public function getArticle(Request $request)
    {
        $article = Article::find($request->id);
        // dd($article);
        if ($article) {
            // SINGLE PRODUCT
            if ($article->type == 'single_product') {
                $feats = explode(',', $article->singleProduct->first()->tags);

                $related =  Product::where('id', '!=', $article->singleProduct->first()->id)
                    ->where('is_active', 1)
                    ->where('category_id', $article->singleProduct->first()->category_id);

                foreach ($feats as $i => $f) {
                    if ($i == 0) {
                        $related = $related->where('tags', 'LIKE', '%' . $f . '%');
                    } else {
                        $related = $related->orWhere('tags', 'LIKE', '%' . $f . '%');
                    }
                }

                $related = $related->where('stock', '>', 0)->take(3)->get();

                $this->data['related']    = $related;
                $this->data['article']    = $article;
                $content                  = view('frontend.includes.modals.parts.part_modal_product', $this->data)->render();

                return response()->json([
                    'status'     => true,
                    'message'    => 'Success',
                    'content'    => $content,
                    'modal'      => '#modal_product',
                ]);
            }

            // TOPTEN
            if ($article->type == 'topten_product') {
                $this->data['article']    = $article;
                $content                  = view('frontend.includes.modals.parts.part_modal_topten_product', $this->data)->render();

                return response()->json([
                    'status'     => true,
                    'message'    => 'Success',
                    'content'    => $content,
                    'modal'      => '#modaltype_top',
                ]);
            }

            // VIDEO PRODUCT
            if ($article->type == 'video_product') {
                $video                    = explode('=', $article->video);
                $video                    = $video[1];

                $this->data['video']      = $video;
                $this->data['article']    = $article;
                $content                  = view('frontend.includes.modals.parts.part_modal_video', $this->data)->render();

                return response()->json([
                    'status'     => true,
                    'message'    => 'Success',
                    'content'    => $content,
                    'modal'      => '#modal_video',
                ]);
            }

            // REVIEW PRODUCT
            if ($article->type == 'review_product') {
                $this->data['article']    = $article;
                $content                  = view('frontend.includes.modals.parts.part_modal_review_product', $this->data)->render();

                return response()->json([
                    'status'     => true,
                    'message'    => 'Success',
                    'content'    => $content,
                    'modal'      => '#modal_review',
                ]);
            }
        }

        return response()->json(['status' => false, 'message' => 'Article Not Exists']);
    }

    public function ovoProcess($order, Request $request)
    {
        $order        = Order::where('order_code', $request->referenceNo)->first();
        $cart         = Cart::find($order->cart_id);
        $cart->status = 'checkout';
        $cart->save();

        $paymentStatus  = new NicepayLib;
        $paymentStatus  = $paymentStatus->checkTransaction($order);
        if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
            if ($order->status == 'pending') {
                $order->status         = 'paid';
                $order->payment_date   = Carbon::parse($paymentStatus->transDt . $paymentStatus->transTm);
                $order->payment_status = 1;
                $order->save();
                $order->refresh();

                session()->forget('voucher');
                $this->reduceStock($cart);
                $this->setSoldProduct($order);
                insertOrderLog($order, 'paid', 'callback ovo');

                event(new Pending($order));

                \Session::flash('success', 'Pembayaran OVO berhasil, Pesanan anda akan segera kami proses. Untuk mengecek pesanan anda mohon cek "My Order" di Profile Account Anda. Terima Kasih');

                header('location: /');
            }

                header('location: /');
        } else {
            $order->status         = 'failed';
            $order->save();
            $order->refresh();

            session()->forget('voucher');
            insertOrderLog($order, 'pending', 'callback ovo');

            \Session::flash('error', 'Pembayaran OVO gagal, silahkan lakukan pemesanan kembali. Terima Kasih');

                header('location: /');
        }

                header('location: /');
    }
}
