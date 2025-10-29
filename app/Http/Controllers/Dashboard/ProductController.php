<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\FileService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductController extends Controller
{

    /**
     * @param FileService $fileService
     */
    public function __construct(protected FileService $fileService)
    {
    }

    /**
     * @return Renderable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): Renderable
    {
        $products = Product::latest()->paginate(20);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        $categories = Category::pluck('name', 'id');
        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->validated());
        
        // Sync categories
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }
        
        $this->fileService->setWidths([Product::IMAGE_WIDTH])
            ->storeEntityImage($request->file('image'), $product);
        flash()->success(__('Product created'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * @param Product $product
     * @return Renderable
     */
    public function show(Product $product): Renderable
    {
        $product->load('categories');
        return view('dashboard.products.show', compact('product'));
    }

    /**
     * @param Product $product
     * @return Renderable
     */
    public function edit(Product $product): Renderable
    {
        $product->load('categories');
        $categories = Category::pluck('name', 'id');
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['is_popular'] = $request->get('is_popular', 0);
        $product->update($data);
        
        // Sync categories
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        } else {
            $product->categories()->detach();
        }
        
        if($request->file('image')){
            $this->fileService->setWidths([Product::IMAGE_WIDTH])
                ->storeEntityImage($request->file('image'), $product);
        }
        flash()->success(__('Product updated'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        flash()->success(__('Product deleted'));

        return redirect()->route('dashboard.products.index');
    }
}
