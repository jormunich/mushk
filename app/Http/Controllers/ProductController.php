<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): Renderable
    {
        $query = Product::query();

        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'review_asc':
                $query->orderBy('review', 'asc');
                break;
            case 'review_desc':
                $query->orderBy('review', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }

    public function show($id): Renderable
    {
        $product = Product::with('categories')->findOrFail($id);

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->whereHas('categories', function($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->take(10)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
