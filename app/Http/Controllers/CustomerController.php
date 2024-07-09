<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function listProducts()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function buyProduct(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $totalPrice = 0;
        foreach ($validated['products'] as $product) {
            $productModel = Product::findOrFail($product['id']);
            $totalPrice += $productModel->price * $product['quantity'];
        }

        $freeShipping = $totalPrice > 15000;
        $discount = $totalPrice > 50000 ? $totalPrice * 0.10 : 0;
        $finalPrice = $totalPrice - $discount;

        $customerId = Auth::id();

        $order = new Order();
        $order->customer_id = $customerId;
        $order->total_price = $finalPrice;
        $order->discount = $discount;
        $order->free_shipping = $freeShipping;
        $order->save();

        foreach ($validated['products'] as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return response()->json($order->load('products'), 201);
    }
}
