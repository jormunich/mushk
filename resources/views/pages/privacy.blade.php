@extends('layouts.app')

@section('content')

    <section class="py-5">
        <div class="container-lg">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Privacy Policy') }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h1 class="display-4 mb-4">{{ __('Privacy Policy') }}</h1>
                            
                            <div class="content">
                                <p class="text-muted">{{ __('Last updated') }}: {{ now()->format('F d, Y') }}</p>
                                
                                <p class="lead">{{ __('Your privacy is important to us. This Privacy Policy explains how we collect, use, and protect your personal information.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('1. Information We Collect') }}</h3>
                                <p>{{ __('We collect information that you provide directly to us, including:') }}</p>
                                <ul>
                                    <li>{{ __('Name and contact information (email address, phone number)') }}</li>
                                    <li>{{ __('Billing and shipping addresses') }}</li>
                                    <li>{{ __('Payment information') }}</li>
                                    <li>{{ __('Account credentials') }}</li>
                                    <li>{{ __('Communications you send to us') }}</li>
                                </ul>
                                
                                <h3 class="mt-4 mb-3">{{ __('2. How We Use Your Information') }}</h3>
                                <p>{{ __('We use the information we collect to:') }}</p>
                                <ul>
                                    <li>{{ __('Process and fulfill your orders') }}</li>
                                    <li>{{ __('Send you order confirmations and updates') }}</li>
                                    <li>{{ __('Respond to your inquiries and requests') }}</li>
                                    <li>{{ __('Improve our website and services') }}</li>
                                    <li>{{ __('Send you marketing communications (with your consent)') }}</li>
                                </ul>
                                
                                <h3 class="mt-4 mb-3">{{ __('3. Information Sharing') }}</h3>
                                <p>{{ __('We do not sell, trade, or rent your personal information to third parties. We may share your information with service providers who assist us in operating our website and conducting our business.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('4. Data Security') }}</h3>
                                <p>{{ __('We implement appropriate security measures to protect your personal information. However, no method of transmission over the Internet is 100% secure.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('5. Cookies') }}</h3>
                                <p>{{ __('We use cookies to enhance your experience on our website. You can choose to disable cookies through your browser settings, but this may affect website functionality.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('6. Your Rights') }}</h3>
                                <p>{{ __('You have the right to:') }}</p>
                                <ul>
                                    <li>{{ __('Access your personal information') }}</li>
                                    <li>{{ __('Correct inaccurate information') }}</li>
                                    <li>{{ __('Request deletion of your information') }}</li>
                                    <li>{{ __('Opt-out of marketing communications') }}</li>
                                </ul>
                                
                                <h3 class="mt-4 mb-3">{{ __('7. Third-Party Links') }}</h3>
                                <p>{{ __('Our website may contain links to third-party websites. We are not responsible for the privacy practices of these external sites.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('8. Children\'s Privacy') }}</h3>
                                <p>{{ __('Our services are not directed to children under 13. We do not knowingly collect personal information from children under 13.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('9. Changes to This Policy') }}</h3>
                                <p>{{ __('We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('10. Contact Us') }}</h3>
                                <p>{{ __('If you have questions about this Privacy Policy, please') }} <a href="{{ route('pages.contact') }}">{{ __('contact us') }}</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



