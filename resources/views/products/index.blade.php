@extends('layouts.app')

@section('content')

    <section id="popular-products" class="products-carousel">
        <div class="container-lg overflow-hidden py-5">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="h3">{{ __('All Products') }}</h2>
                    <p class="text-muted">{{ __('Showing') }} {{ $products->count() }} {{ __('products') }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <form method="GET" action="{{ route('products.index') }}" id="sort-form" class="d-inline-block">
                        @if(request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <label for="sort-select" class="form-label d-inline me-2">{{ __('Sort by:') }}</label>
                        <select name="sort" id="sort-select" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                            <option value="default" {{ request('sort') == 'default' || !request('sort') ? 'selected' : '' }}>{{ __('Default') }}</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('Price: Low to High') }}</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('Price: High to Low') }}</option>
                            <option value="review_asc" {{ request('sort') == 'review_asc' ? 'selected' : '' }}>{{ __('Review: Low to High') }}</option>
                            <option value="review_desc" {{ request('sort') == 'review_desc' ? 'selected' : '' }}>{{ __('Review: High to Low') }}</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="swiper">
                        <div class="swiper-wrapper row">
                            @foreach($products as $product)
                            <div class="product-item col-md-3"
                                 data-product-id="{{ $product->id }}"
                                 data-product-name="{{ $product->name }}"
                                 data-product-price="{{ $product->price }}"
                                 data-product-image="{{ $product->getFilePath() }}">
                                <figure>
                                    <a href="{{ route('products.show', $product->id) }}" title="{{ $product->name }}">
                                        <img src="{{ $product->getFilePath() }}" alt="{{ $product->name }}" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">{{ $product->name }}</h3>
                                    <div>
                                        {!! $product->stars !!}
                                        <span>({{ $product->review_count }})</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        @if($product->old_price)
                                            <del>{{ $product->old_price_formatted }}</del>
                                        @endif
                                        <span class="text-dark fw-semibold">{{ $product->price_formatted }}</span>
                                            @if($product->old_price)
                                            <span class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">{{ $product->sale_percent }}% {{ __('OFF') }}</span>
                                            @endif
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity" class="form-control border-dark-subtle input-number quantity" value="1" min="1"></div>
                                            <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18"><use xlink:href="#cart"></use></svg> {{ __('Add to Cart') }}</a></div>
                                            <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6" data-favorite-id="{{ $product->id }}"><svg width="18" height="18"><use xlink:href="#heart"></use></svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
