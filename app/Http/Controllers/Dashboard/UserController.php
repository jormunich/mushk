<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserController extends Controller
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
        $data = $this->userService->getFormData();

        return view('dashboard.users.create', $data);
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $this->userService->store($request->validated());
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
        $data = $this->userService->getFormData($user);

        return view('dashboard.users.edit', $data);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->userService->update($user, $request->validated());
        flash()->success(__('User updated'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->userService->delete($user);
        flash()->success(__('User deleted'));

        return redirect()->route('dashboard.users.index');
    }
}
