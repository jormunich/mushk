<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EmailSubscriber;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EmailSubscriberController extends Controller
{
    /**
     * Display a listing of email subscribers.
     *
     * @return Renderable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): Renderable
    {
        $subscribers = EmailSubscriber::latest()->paginate(20);

        return view('dashboard.subscribers.index', compact('subscribers'));
    }

    /**
     * Remove the specified subscriber.
     *
     * @param EmailSubscriber $emailSubscriber
     * @return RedirectResponse
     */
    public function destroy(EmailSubscriber $emailSubscriber): RedirectResponse
    {
        $emailSubscriber->delete();
        flash()->success(__('Subscriber deleted'));

        return redirect()->route('dashboard.subscribers.index');
    }
}
