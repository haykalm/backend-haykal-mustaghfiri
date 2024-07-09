<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class MerchantController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth.jwt:merchant');
    // }

    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = new Product($validated);
        $product->merchant_id = Auth::id();
        $product->save();

        return response()->json($product, 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('merchant_id', Auth::id())->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);
        return response()->json($product, 200);
    }

    public function deleteProduct($id)
    {
        $product = Product::where('merchant_id', Auth::id())->findOrFail($id);
        // $productOriginal = $product->getOriginal();
        // $product->delete();

        return response()->json(['message' => "Product deleted successfully"], 204);
    }

    public function getCustomers()
    {
        $customers = Order::whereHas('products', function ($query) {
            $query->where('merchant_id', Auth::id());
        })->with('customer')->distinct()->get();

        return response()->json($customers, 200);
    }
}
