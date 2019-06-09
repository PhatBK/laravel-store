<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Product;
use App\Cart;

class CartController extends Controller
{

    /**
     * Add to cart the specified resource.
     *
     * @param  Product $product
     * @return 
     */
    public function addToCart(Product $product)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product);
        session(['cart' => $cart]);

        // return redirect()->route('products.index');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCart()
    {
        $cart = Session::has('cart') ? Session::get('cart') : '';
        // abort_if ( !$cart, 404 );
        return view('cart.index', compact('cart'));
    }

    /**
     * Remove the specified resource from cart.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteItem(Product $product)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove($product);
        session(['cart' => $cart]);
        return view('cart.index', compact('cart'));
    }

    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function changeItem(Product $product)
    {
        $cart = Session::has('cart') ? Session::get('cart') : '';
        abort_if ( !$cart, 404 );

        $validator = request()->validate([
            'quantity' => 'required|integer|min:1|max:255', // max - remaind in storage
        ]);

        $cart->change($product, request('quantity'));

        return view('cart.index', compact('cart'));
    }

}
