<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts.
     *
     * @return Renderable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): Renderable
    {
        $contacts = Contact::latest()->paginate(20);

        return view('dashboard.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified contact.
     *
     * @param Contact $contact
     * @return Renderable
     */
    public function show(Contact $contact): Renderable
    {
        return view('dashboard.contacts.show', compact('contact'));
    }

    /**
     * Remove the specified contact.
     *
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        flash()->success(__('Contact deleted'));

        return redirect()->route('dashboard.contacts.index');
    }
}
