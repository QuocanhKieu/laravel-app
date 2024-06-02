<?php

namespace App;

use App\Models\Cart as CartModel;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Session::start();
class Cart
{
    public $products = [];
    public $cartTotalPrice = 0;
    public $cartTotalQuantity = 0;

    public function __construct($cart = null)
    {
        if ($cart) {
            $this->products = $cart->products;
            $this->cartTotalPrice = $cart->cartTotalPrice;
            $this->cartTotalQuantity = $cart->cartTotalQuantity;
        }
    }

    public function addProduct($productId, $sizeId, $quantity = 1)
    {$product = Product::find($productId);

        if (!$product) {
            return false; // Handle case where product doesn't exist
        }

        $productIdSizeId = $productId . '_' . $sizeId;

        if (isset($this->products[$productIdSizeId])) {
            $this->products[$productIdSizeId]['quantity'] += $quantity;
            $this->products[$productIdSizeId]['totalPrice'] = $this->products[$productIdSizeId]['quantity'] * $product->sale_price;
        } else {
            $this->products[$productIdSizeId] = [
                'product_id' => $productId,
                'size_id' => $sizeId,
                'quantity' => $quantity,
                'price' => $product->sale_price,
                'totalPrice' => $quantity * $product->sale_price, // Calculate total price for the new product
                'thisProduct' => $product
            ];
        }

        $this->updateTotals();

        return true;
    }

    public function updateTotals()
    {
        $this->cartTotalPrice = 0;
        $this->cartTotalQuantity = 0;

        foreach ($this->products as $item) {
            $this->cartTotalPrice += $item['totalPrice'];
            $this->cartTotalQuantity += $item['quantity'];
        }
    }

    public static function loadFromSession()
    {
        $cartData = Session::get('cart');

        if (!$cartData) {
            return new Cart(); // Return an empty cart if not found in session
        }

        $cart = new Cart();
        $cart->products = $cartData['products'];
        $cart->cartTotalPrice = $cartData['cartTotalPrice'];
        $cart->cartTotalQuantity = $cartData['cartTotalQuantity'];

        return $cart;
    }

    public static function saveToSession($cart)
    {
        Session::put('cart', [
            'products' => $cart->products,
            'cartTotalPrice' => $cart->cartTotalPrice,
            'cartTotalQuantity' => $cart->cartTotalQuantity,
        ]);
    }

    public function removeProduct($productId, $sizeId)
    {
        $productIdSizeId = $productId . '_' . $sizeId;

        if (isset($this->products[$productIdSizeId])) {
            unset($this->products[$productIdSizeId]);
            $this->updateTotals();
            return true;
        }

        return false; // Handle case where product not found in cart
    }

    public function updateQuantity($productId, $sizeId, $quantity)
    {
        $productIdSizeId = $productId . '_' . $sizeId;

        if (isset($this->products[$productIdSizeId])) {
            $this->products[$productIdSizeId]['quantity'] = $quantity;
            $this->products[$productIdSizeId]['totalPrice'] = $quantity * $this->products[$productIdSizeId]['price'];
            $this->updateTotals();
            return true;
        }

        return false; // Handle case where product not found in cart
    }

    public function clearCart()
    {
        $this->products = [];
        $this->cartTotalPrice = 0;
        $this->cartTotalQuantity = 0;
    }
    public function saveToDatabase()
    {
        if (!Auth::check()) {
            return false; // Only save to database if user is authenticated
        }

        $cartData = [
            'products' => $this->products,
            'cartTotalPrice' => $this->cartTotalPrice,
            'cartTotalQuantity' => $this->cartTotalQuantity,
        ];

        $cartModel = CartModel::updateOrCreate(
            ['user_id' => Auth::id()],
            ['cart_data' => json_encode($cartData)]
        );

        return true;
    }

    public static function loadFromDatabase($userId)
    {
        $cartModel = CartModel::where('user_id', $userId)->latest()->first();

        if (!$cartModel) {
            return null; // Handle case where cart for user not found
        }

        $cartData = json_decode($cartModel->cart_data, true);

        $cart = new Cart();
        $cart->products = $cartData['products'];
        $cart->cartTotalPrice = $cartData['cartTotalPrice'];
        $cart->cartTotalQuantity = $cartData['cartTotalQuantity'];

        return $cart;
    }

}
