<?php

namespace App\Http\Controllers;

use App\CartProduct;
use App\Product;
use App\ProductVariation;
use Illuminate\Http\Request;

class CartProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $service_charge = number_format($total * 2 / 100, 2);
        $paypal_total = $total + $service_charge;
        $total_float = floatval($total);
        $balance_float = floatval($balance);
        if ($balance_float < $total_float) {
            $sufficient = false;
        } else {
            $sufficient = true;
        }
        if ($user->isAdmin()) {
            var_dump($total);
            var_dump($total_float);
            var_dump($balance);
            var_dump($balance_float);
            var_dump($sufficient);
            dd('testing');
        }

        return view('products.cart', compact('items', 'total', 'service_charge', 'paypal_total', 'balance', 'sufficient'));
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
            \Log::debug('Controller - Product ID: ' . $product_id . ' - ' . $product);
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
