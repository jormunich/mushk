@extends('dashboard.layouts.app')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ __('Edit category') }}</h3>
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
                    <a href="#">{{ __('Edit category') }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ __('Edit category') }}</div>
                    </div>
                    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @include('dashboard.categories.components._form', ['model' => $category])
                        <div class="card-action">
                            <button class="btn btn-success" type="submit">{{ __('Submit') }}</button>
                            <button class="btn btn-danger _m_back" type="button">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
