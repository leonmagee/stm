<?php

namespace App\Http\Controllers;

use App\CartCoupon;
use App\CartProduct;
use App\Coupon;
use App\Product;
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
        $user = \Auth::user();
        $balance = $user->balance;
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
        // calculate service charge
        $service_charge = number_format($total * 2 / 100, 2);
        // get coupon info
        $coupon = false;
        $cart_coupon = CartCoupon::where('user_id', $user->id)->first();
        if ($cart_coupon) {
            $coupon = Coupon::find($cart_coupon->coupon_id);
            if (!$coupon) {
                $cart_coupon->delete();
            }
        }
        $subtotal = $total;
        $coupon_discount = false;
        if ($coupon) {
            $coupon_discount = $total * ($coupon->percent / 100);
            $total = $total - $coupon_discount;
        }

        if ($total < $this->shipping_max) {
            $shipping_charge = $this->shipping_charge;
            $total = $total + $shipping_charge;
            $paypal_total = $total + $service_charge;
        } else {
            $shipping_charge = 0;
            $paypal_total = $total + $service_charge;
        }
        //dd($paypal_total);
        $total_float = floatval(strval($total));
        $balance_float = floatval(strval($balance));
        if ($balance_float < $total_float) {
            $sufficient = false;
        } else {
            $sufficient = true;
        }

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

        return view('products.cart', compact(
            'items',
            'total',
            'service_charge',
            'paypal_total',
            'balance',
            'sufficient',
            'shipping_charge',
            'subtotal',
            'shipping_max',
            'shipping_default',
            'coupon',
            'coupon_discount'
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
        }
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
