<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Session::start();
class CartController extends Controller
{
    public function addToCart(Request $request,)
    {
//        Session::flush();
//        return false;
        $quantity = $request->quantity ?? 1;
        $productId = $request->productId;
        $sizeId = $request->sizeId;

//        Session::regenerate();
        $cart = Cart::loadFromSession();

        if ($cart->addProduct((int)$productId, (int)$sizeId, (int)$quantity)) {
            Cart::saveToSession($cart);
            if (Auth::check()) {
//                $cart->saveToDatabase();

            }

            $view = view('partials.smallCart')->render();
            return response()->json(['success' => true, 'message' => 'Product added to cart.', 'view' => $view], );
        }

        return response()->json(['success' => false, 'message' => 'Something went wrong.']);
    }
    public function removeFromCart(Request $request)
    {
        $productId = $request->productId;
        $sizeId = $request->sizeId;
        $cart = Cart::loadFromSession();
        if ($cart->removeProduct($productId, $sizeId)) {
            Cart::saveToSession($cart);

            if (Auth::check()) {
//                $cart->saveToDatabase();
            }
            $view = view('partials.smallCart')->render();

            return response()->json(['success' => true, 'message' => 'Product removed from cart successfully.', 'view' => $view]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart.']);
    }

    public function updateCartItem(Request $request) {
        $quantity = $request->quantity;
        $productId = $request->productId;
        $sizeId = $request->sizeId;
//        dd($quantity,$productId,$sizeId);
//        Session::regenerate();
        $cart = Cart::loadFromSession();

        if ($cart->updateQuantity((int)$productId, (int)$sizeId, (int)$quantity)) {
            Cart::saveToSession($cart);
            if (Auth::check()) {
//                $cart->saveToDatabase();

            }
            $view = view('partials.smallCart')->render();
            return response()->json(['success' => true, 'message' => 'Product Quantity updated to cart successfully.', 'view' => $view], );
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart.']);
    }

}
