<footer class="py-5">
    <div class="container-lg">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">
                    <img src="/images/logo.svg" width="240" height="70" alt="logo">
                    <div class="social-links mt-3">
                        <ul class="d-flex list-unstyled gap-2">
                            <li>
                                <a href="#" class="btn btn-outline-light" target="_blank">
                                    <svg width="16" height="16"><use xlink:href="#facebook"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-outline-light" target="_blank">
                                    <svg width="16" height="16"><use xlink:href="#twitter"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-outline-light" target="_blank">
                                    <svg width="16" height="16"><use xlink:href="#youtube"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/imperial_greensss" class="btn btn-outline-light" target="_blank">
                                    <svg width="16" height="16"><use xlink:href="#instagram"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-outline-light" target="_blank">
                                    <svg width="16" height="16"><use xlink:href="#amazon"></use></svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">{{ __('Mushk') }}</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item">
                            <a href="{{ route('pages.about') }}" class="nav-link">{{ __('About us') }}</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">{{ __('Careers') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">{{ __('Quick Links') }}</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item">
                            <a href="#" class="nav-link">{{ __('Stores') }}</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('products.index') }}" class="nav-link">{{ __('Shop') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">{{ __('Customer Service') }}</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item">
                            <a href="{{ route('pages.contact') }}" class="nav-link">{{ __('Contact') }}</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('pages.privacy') }}" class="nav-link">{{ __('Privacy Policy') }}</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('pages.terms') }}" class="nav-link">{{ __('Terms & Conditions') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">{{ __('Subscribe Us') }}</h5>
                    <p>{{ __('Subscribe to our newsletter to get updates about our grand offers') }}.</p>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form class="d-flex mt-3 gap-0" action="{{ route('pages.subscribe') }}" method="POST">
                        @csrf
                        <input class="form-control rounded-start rounded-0 bg-light @error('email') is-invalid @enderror" 
                               type="email" 
                               name="email" 
                               placeholder="{{ __('Email Address') }}" 
                               aria-label="Email Address"
                               value="{{ old('email') }}"
                               required>
                        <button class="btn btn-dark rounded-end rounded-0" type="submit">{{ __('Subscribe') }}</button>
                    </form>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>
    </div>
</footer>

<div id="footer-bottom">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-6 copyright">
                <p>© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved')}}.</p>
            </div>
            <div class="col-md-6 credit-link text-start text-md-end">
                <p>{{ __('Designed by') }} <a href="https://munich.ventures/" target="_blank">{{ __('Munich Ventures') }}</a></p>
            </div>
        </div>
    </div>
</div>
