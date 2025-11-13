@extends('layouts.app')

@section('content')

    <section class="py-5">
        <div class="container-lg">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('About Us') }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h1 class="display-4 mb-4">{{ __('About Us') }}</h1>
                            
                            <div class="content">
                                <p class="lead">{{ __('Welcome to') }} {{ config('app.name') }}!</p>
                                
                                <p>{{ __('We are dedicated to providing you with the freshest, highest quality organic and natural products. Our mission is to make healthy living accessible and convenient for everyone.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('Our Story') }}</h3>
                                <p>{{ __('Founded with a passion for quality and sustainability, we have been serving our community with premium products sourced directly from trusted farmers and suppliers. We believe in building lasting relationships with our customers and partners.') }}</p>
                                
                                <h3 class="mt-4 mb-3">{{ __('Our Values') }}</h3>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <svg width="20" height="20" class="text-primary me-2"><use xlink:href="#check"></use></svg>
                                        <strong>{{ __('Quality First') }}:</strong> {{ __('We ensure all products meet our high standards.') }}
                                    </li>
                                    <li class="mb-2">
                                        <svg width="20" height="20" class="text-primary me-2"><use xlink:href="#check"></use></svg>
                                        <strong>{{ __('Sustainability') }}:</strong> {{ __('We care about the environment and support eco-friendly practices.') }}
                                    </li>
                                    <li class="mb-2">
                                        <svg width="20" height="20" class="text-primary me-2"><use xlink:href="#check"></use></svg>
                                        <strong>{{ __('Customer Satisfaction') }}:</strong> {{ __('Your happiness is our priority.') }}
                                    </li>
                                    <li class="mb-2">
                                        <svg width="20" height="20" class="text-primary me-2"><use xlink:href="#check"></use></svg>
                                        <strong>{{ __('Community') }}:</strong> {{ __('We support and give back to our local community.') }}
                                    </li>
                                </ul>
                                
                                <h3 class="mt-4 mb-3">{{ __('Why Choose Us') }}</h3>
                                <p>{{ __('At') }} {{ config('app.name') }}, {{ __('we offer an extensive selection of organic products, competitive pricing, fast delivery, and exceptional customer service. We are committed to being your trusted partner in health and wellness.') }}</p>
                                
                                <p class="mt-4">{{ __('Thank you for choosing') }} {{ config('app.name') }}. {{ __('We look forward to serving you!') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



