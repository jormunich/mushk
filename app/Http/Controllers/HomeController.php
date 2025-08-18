<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    public function index(): Renderable
    {
        $categories = Category::all();
        $popularProducts = Product::where('is_popular', 1)->inRandomOrder()->take(10)->get();
        $newProducts = Product::latest()->take(10)->get();

        return view('home', compact('categories', 'popularProducts', 'newProducts'));
    }
}
