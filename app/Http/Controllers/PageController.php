<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\EmailSubscriber;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Display the about us page.
     */
    public function about(): Renderable
    {
        return view('pages.about');
    }

    /**
     * Display the contact us page.
     */
    public function contact(): Renderable
    {
        return view('pages.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function storeContact(ContactRequest $request): RedirectResponse
    {
        $contact = Contact::create($request->validated());

        $adminEmail = config('mail.from.address');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactMail($contact));
        }

        return redirect()->route('pages.contact')
            ->with('success', __('Thank you for contacting us! We will get back to you soon.'));
    }

    /**
     * Display the terms and conditions page.
     */
    public function terms(): Renderable
    {
        return view('pages.terms');
    }

    /**
     * Display the privacy policy page.
     */
    public function privacy(): Renderable
    {
        return view('pages.privacy');
    }

    /**
     * Handle newsletter subscription.
     */
    public function subscribe(SubscriptionRequest $request): RedirectResponse
    {
        $subscriber = EmailSubscriber::firstOrCreate([
            'email' => $request->email,
        ]);

        if ($subscriber->wasRecentlyCreated) {
            return redirect()->back()
                ->with('success', __('Thank you for subscribing to our newsletter!'));
        }

        return redirect()->back()
            ->with('info', __('You are already subscribed to our newsletter.'));
    }

    /**
     * Display the shopping cart page.
     */
    public function cart(): Renderable
    {
        return view('pages.cart');
    }
}
