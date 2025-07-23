<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CategoryController extends Controller
{
    /**
     * @return Renderable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): Renderable
    {
        $categories = Category::latest()->paginate(20);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('dashboard.categories.create');
    }

    /**
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());
        flash()->success(__('Category created'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * @param Category $category
     * @return Renderable
     */
    public function show(Category $category): Renderable
    {
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * @param Category $category
     * @return Renderable
     */
    public function edit(Category $category): Renderable
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());
        flash()->success(__('Category updated'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        flash()->success(__('Category deleted'));

        return redirect()->route('dashboard.categories.index');
    }
}
