@extends('dashboard.layouts.app')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ __('Show category') }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.categories.index') }}">{{ __('Categories') }}</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ __('Show category') }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">{{ $category->name }}</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="number">{{ $category->products()->count() }}</div>
                                <div class="title">{{ __('Products') }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('/dashboard/img/default.webp') }}" width="150px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
