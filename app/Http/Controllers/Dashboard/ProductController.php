<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductController extends Controller
{
    /**
     * @return Renderable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): Renderable
    {
        $users = User::latest()->paginate(20);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        $roles = User::ROLES;

        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());
        flash()->success(__('User created'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function show(User $user): Renderable
    {
        return view('dashboard.users.show', compact('user'));
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function edit(User $user): Renderable
    {
        $roles = User::ROLES;

        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());
        flash()->success(__('User updated'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        flash()->success(__('User deleted'));

        return redirect()->route('dashboard.users.index');
    }
}
