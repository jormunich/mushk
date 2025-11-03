@extends('layouts.app')

@section('content')

    <section class="py-5">
        <div class="container-lg">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Terms and Conditions') }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h1 class="display-4 mb-4">{{ __('Terms and Conditions') }}</h1>
                            
                            <div class="content">
                                <p class="text-muted">{{ __('Last updated') }}: {{ now()->format('F d, Y') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('1. Acceptance of Terms') }}</h3>
                                <p>{{ __('By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('2. Use License') }}</h3>
                                <p>{{ __('Permission is granted to temporarily use materials on this website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('3. Product Information') }}</h3>
                                <p>{{ __('We strive to provide accurate product descriptions and images. However, we do not warrant that product descriptions or other content on this site is accurate, complete, reliable, current, or error-free.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('4. Pricing and Payment') }}</h3>
                                <p>{{ __('All prices are in USD and are subject to change without notice. We reserve the right to modify prices at any time. Payment must be received before order processing.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('5. Shipping and Delivery') }}</h3>
                                <p>{{ __('Shipping costs and delivery times are estimates and may vary. We are not responsible for delays caused by shipping carriers or customs.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('6. Returns and Refunds') }}</h3>
                                <p>{{ __('Returns must be made within 30 days of purchase. Products must be in original condition. Refunds will be processed within 14 business days after receiving returned items.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('7. Limitation of Liability') }}</h3>
                                <p>{{ __('In no event shall') }} {{ config('app.name') }} {{ __('or its suppliers be liable for any damages arising out of the use or inability to use the materials on this website.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('8. Privacy Policy') }}</h3>
                                <p>{{ __('Your use of this website is also governed by our Privacy Policy. Please review our Privacy Policy to understand our practices.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('9. Modifications') }}</h3>
                                <p>{{ __('We reserve the right to revise these terms at any time without notice. By using this website you are agreeing to be bound by the current version of these Terms and Conditions.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('10. Contact Information') }}</h3>
                                <p>{{ __('If you have any questions about these Terms and Conditions, please') }} <a href="{{ route('pages.contact') }}">{{ __('contact us') }}</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


