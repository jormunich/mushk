@extends('layouts.app')

@section('content')

    <section class="py-5">
        <div class="container-lg">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Products') }}</a></li>
                    @if($product->categories->isNotEmpty())
                        <li class="breadcrumb-item"><a href="{{ route('products.index', ['category_id' => $product->categories->first()->id]) }}">{{ $product->categories->first()->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="product-image position-relative">
                        <img src="{{ $product->getFilePath() }}" alt="{{ $product->name }}" class="img-fluid rounded">
                        @if($product->old_price)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3">{{ $product->sale_percent }}% {{ __('OFF') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="product-details">
                        <h1 class="h2 mb-3">{{ $product->name }}</h1>

                        @if($product->categories->isNotEmpty())
                            <div class="mb-3">
                                <span class="text-muted fw-semibold">{{ __('Category') }}: </span>
                                @foreach($product->categories as $category)
                                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="badge bg-primary text-decoration-none me-1">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="d-flex align-items-center gap-1">
                                {!! $product->stars !!}
                            </div>
                            <span class="text-muted">({{ $product->review_count }} {{ __('reviews') }})</span>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                @if($product->old_price)
                                    <span class="h3 text-muted text-decoration-line-through mb-0">{{ $product->old_price_formatted }}</span>
                                @endif
                                <span class="h2 text-primary mb-0">{{ $product->price_formatted }}</span>
                            </div>
                        </div>

                        @if($product->description)
                            <div class="mb-4">
                                <h5 class="mb-3">{{ __('Description') }}</h5>
                                <p class="text-muted">{{ $product->description }}</p>
                            </div>
                        @endif

                        <div class="border-top pt-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label class="form-label fw-semibold mb-2">{{ __('Quantity') }}</label>
                                    <div class="d-flex">
                                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                                        <input type="number" name="quantity" id="quantity" class="form-control text-center quantity-input" value="1" min="1">
                                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <label class="form-label d-block mb-2" style="visibility: hidden;">{{ __('Action') }}</label>
                                    <a href="#" class="btn btn-primary btn-lg px-5" onclick="addToCart(event)">
                                        <svg width="20" height="20" class="me-2"><use xlink:href="#cart"></use></svg>
                                        {{ __('Add to Cart') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-top">
                            <h6 class="mb-3">{{ __('Share this product') }}</h6>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    <svg width="16" height="16"><use xlink:href="#facebook"></use></svg>
                                </a>
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    <svg width="16" height="16"><use xlink:href="#twitter"></use></svg>
                                </a>
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    <svg width="16" height="16"><use xlink:href="#instagram"></use></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs border-0" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">{{ __('Description') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">{{ __('Reviews') }}</button>
                        </li>
                    </ul>
                    <div class="tab-content border-top pt-4">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <p class="text-muted">
                                @if($product->description)
                                    {{ $product->description }}
                                @else
                                    {{ __('No description available for this product.') }}
                                @endif
                            </p>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews-section">
                                <h5>{{ __('Customer Reviews') }}</h5>
                                <p class="text-muted">({{ $product->review_count }} {{ __('Reviews') }})</p>
                                <div class="d-flex align-items-center gap-1">
                                    {!! $product->stars !!}
                                </div>
                                <div class="mt-4">
                                    <p>{{ __('No feedbacks yet') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="mt-5 py-4">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="mb-4">{{ __('Related Products') }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    @foreach($relatedProducts as $relatedProduct)
                                        <div class="swiper-slide">
                                            <div class="product-item">
                                                <figure>
                                                    <a href="{{ route('products.show', $relatedProduct->id) }}" title="{{ $relatedProduct->name }}">
                                                        <img src="{{ $relatedProduct->getFilePath() }}" alt="{{ $relatedProduct->name }}" class="tab-image">
                                                    </a>
                                                </figure>
                                                <div class="d-flex flex-column text-center">
                                                    <h3 class="fs-6 fw-normal">{{ $relatedProduct->name }}</h3>
                                                    <div>
                                                        {!! $relatedProduct->stars !!}
                                                        <span>({{ $relatedProduct->review_count }})</span>
                                                    </div>
                                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                                        @if($relatedProduct->old_price)
                                                            <del>{{ $relatedProduct->old_price_formatted }}</del>
                                                        @endif
                                                        <span class="text-dark fw-semibold">{{ $relatedProduct->price_formatted }}</span>
                                                        @if($relatedProduct->old_price)
                                                            <span class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">{{ $relatedProduct->sale_percent }}% {{ __('OFF') }}</span>
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
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>

    <script>
        function increaseQuantity() {
            var quantity = document.getElementById('quantity');
            quantity.value = parseInt(quantity.value) + 1;
        }

        function decreaseQuantity() {
            var quantity = document.getElementById('quantity');
            if (parseInt(quantity.value) > 1) {
                quantity.value = parseInt(quantity.value) - 1;
            }
        }

        function addToCart(event) {
            event.preventDefault();
            // Add cart functionality here
            alert('Product added to cart!');
        }
    </script>

@endsection
