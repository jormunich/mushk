<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): Renderable
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function show($id): Renderable
    {
        $product = Product::findOrFail($id);

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->whereHas('categories', function($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->take(10)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
