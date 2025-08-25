@extends('layouts.app')

@section('content')

    <section id="popular-products" class="products-carousel">
        <div class="container-lg overflow-hidden py-5">
            <div class="row">
                <div class="col-md-12">

                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @foreach($products as $product)
                            <div class="product-item swiper-slide">
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
                                            <div class="col-3"><input type="number" name="quantity" class="form-control border-dark-subtle input-number quantity" value="1"></div>
                                            <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18"><use xlink:href="#cart"></use></svg> {{ __('Add to Cart') }}</a></div>
                                            <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18" height="18"><use xlink:href="#heart"></use></svg></a></div>
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
