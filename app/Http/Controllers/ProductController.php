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

        return view('products.show', compact('product'));
    }
}
