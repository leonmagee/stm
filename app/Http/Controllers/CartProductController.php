<?php

namespace App\Http\Controllers;

use App\CartCoupon;
use App\CartProduct;
use App\Coupon;
use App\Helpers;
use App\Product;
use App\ProductFavorite;
use App\ProductSave;
use App\ProductVariation;
use Illuminate\Http\Request;

class CartProductController extends Controller
{
    private $shipping_charge;
    public function __construct()
    {
        $this->middleware('auth');
        $this->shipping_charge = config('app.stm_shipping');
        $this->shipping_max = config('app.stm_min_total');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Log::debug('test');
        $user = \Auth::user();
        $balance = $user->balance;
        if ($user->store_credit) {
            $store_credit = floatval(number_format($user->store_credit, 2));
        } else {
            $store_credit = false;
        }
        $user_id = $user->id;
        $items = CartProduct::where('user_id', $user_id)->get();
        $total = 0;
        foreach ($items as $key => $item) {
            $total += $item->product->discount_cost() * $item->quantity;
            $variation = ProductVariation::where(['product_id' => $item->product_id, 'text' => $item->variation])->first();
            if ($variation) {
                if ($variation->quantity < 1) {
                    $item->delete();
                } else if ($variation->quantity < $item->quantity) {
                    $item->quantity = $variation->quantity;
                    $item->save();
                }
            } else {
                $item->delete();
                unset($items[$key]);
            }
        }
        // get coupon info
        $coupon = false;
        $cart_coupon = CartCoupon::where('user_id', $user->id)->first();
        if ($cart_coupon) {
            $coupon = Coupon::find($cart_coupon->coupon_id);
            if (!$coupon) {
                $cart_coupon->delete();
            }
        }
        // calculate service charge
        $service_charge = number_format($total * 2 / 100, 2);
        $subtotal = $total;
        $paypal_discount = 0;
        $coupon_discount = 0;
        $item_total = $total;
        if ($coupon) {
            $coupon_discount = floatval(strval(number_format($total * ($coupon->percent / 100), 2)));
            $paypal_discount = $coupon_discount;
            $total = $total - $coupon_discount;
            //$coupon_discount_neg = -1 * $coupon_discount;
        }

        if ($total < $this->shipping_max) {
            $shipping_charge = $this->shipping_charge;
            $total = $total + $shipping_charge;
            $item_total = $item_total + $shipping_charge;
            $paypal_total = $total + $service_charge;
            $paypal_total_item = $item_total + $service_charge;
            // dd($paypal_total);
            // dd($coupon_discount);
            // dd($paypal_total_item);
        } else {
            $shipping_charge = 0;
            $paypal_total = $total + $service_charge;
            $paypal_total_item = $item_total + $service_charge;
        }
        //dd($paypal_total);
        $total_float = floatval(strval($total));
        $balance_float = floatval(strval($balance));
        if ($balance_float < ($total_float - $store_credit)) {
            $sufficient = false;
        } else {
            $sufficient = true;
        }
        $covered_by_credit = false;
        if ($store_credit) {
            if ($total <= $store_credit) {
                $store_credit = $total;
                $total = 0;
                $covered_by_credit = true;
            } else {
                $total = $total - $store_credit;
                $paypal_total = $paypal_total - $store_credit;
                $paypal_discount += $store_credit;

            }

        }

        //dd($service_charge);
        //dd($paypal_total); // this is minus the discount
        //dd($paypal_total_item);

        // if ($user->isAdmin()) {
        //     var_dump($total);
        //     var_dump($total_float);
        //     var_dump($balance);
        //     var_dump($balance_float);
        //     var_dump($sufficient);
        //     dd('testing');
        // }
        $shipping_max = $this->shipping_max;
        $shipping_default = $this->shipping_charge;

        // get saved products
        $saves = ProductSave::select('product_id')->where('user_id', $user_id)->get()->toArray();
        $save_array = [];
        foreach ($saves as $save) {
            $save_array[] = $save['product_id'];
        }
        //$saved_products = Product::whereIn('id', $save_array)->orderBy('order')->get();

        // get favorite products
        $favorites = ProductFavorite::select('product_id')->where('user_id', $user_id)->get()->toArray();
        $fav_array = [];
        //dd($favorites);
        foreach ($favorites as $favorite) {
            $fav_array[] = $favorite['product_id'];
        }
        /**
         * @todo change to 'wish list' - not 'fav'
         */
        $fav_products = Product::whereIn('id', $fav_array)->orderBy('order')->get();
        //$related_array = [];
        // foreach ($fav_products as $fav) {
        //     $fav->get_related();
        // }
        // dd($related_array);
        // if ($total <= 0) {
        //     $total = 0;
        // }

        return view('products.cart', compact(
            'items',
            'total',
            'service_charge',
            'paypal_total',
            'paypal_total_item',
            'balance',
            'store_credit',
            'sufficient',
            'shipping_charge',
            'subtotal',
            'shipping_max',
            'shipping_default',
            'coupon',
            'cart_coupon',
            'coupon_discount',
            'paypal_discount',
            //'saved_products',
            'fav_products',
            'covered_by_credit'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = \Auth::user()->id;

        $existing = CartProduct::where([
            'product_id' => $request->product_id,
            'user_id' => $user_id,
            'variation' => $request->variation,
        ])->first();
        if ($existing) {
            $existing->delete();
        }

        CartProduct::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'variation' => $request->variation,
            'user_id' => $user_id,
        ]);
        return back()->withMessage('Added to Cart. <a href="/cart">Checkout</a>.');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_sav_fav($product_id)
    {
        $user_id = \Auth::user()->id;
        $product = Product::find($product_id);
        //dd($product);
        $variation = $product->first_variation();
        if ($variation) {
            $existing = CartProduct::where([
                'product_id' => $product_id,
                'user_id' => $user_id,
            ])->first();
            if (!$existing) {
                CartProduct::create([
                    'product_id' => $product_id,
                    'quantity' => 1,
                    'variation' => $variation,
                    'user_id' => $user_id,
                ]);
            }
        }

        $product_saved = ProductSave::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        if ($product_saved) {
            $product_saved->delete();
        }

        return back()->withMessage('Added to Cart.');

    }

    /**
     * Store item in cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_axios(Request $request)
    {
        $user_id = \Auth::user()->id;
        $product_id = $request->id;
        $product = Product::find($product_id);
        $variation = $product->first_variation();
        if ($variation) {
            //\Log::debug('Controller - Product ID: ' . $product_id . ' - ' . $product);
            //dd('product', $product);
            $existing = CartProduct::where([
                'product_id' => $product_id,
                'user_id' => $user_id,
                //'variation' => $variation,
            ])->first();
            if (!$existing) {
                CartProduct::create([
                    'product_id' => $product_id,
                    'quantity' => 1,
                    'variation' => $variation,
                    'user_id' => $user_id,
                ]);
            }

            $cart_items = Helpers::get_number_cart_items();

            return $cart_items;
        }
    }

    /**
     * Remove item from cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function remove_axios(Request $request)
    {
        $user_id = \Auth::user()->id;
        $product_id = $request->id;
        $product = Product::find($product_id);
        $cart_product = CartProduct::where([
            'product_id' => $product_id,
            'user_id' => $user_id,
        ])->first();
        $cart_product->delete();

        $cart_items = Helpers::get_number_cart_items();

        return $cart_items;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CartProduct $cartProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CartProduct $cartProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartProduct $item)
    {
        $item->variation = $request->variation;
        $max = $item->color_quantity($item->product->id, $item->variation);
        $item->quantity = $request->quantity ? $request->quantity : 1;
        if ($item->quantity > $max) {
            $item->quantity = $max;
        }
        $item->save();
        return redirect('/cart');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartProduct $item)
    {
        $item->delete();
        session()->flash('danger', 'Item Has Been Removed');
        return redirect('/cart');
    }
}
