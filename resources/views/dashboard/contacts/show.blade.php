@extends('dashboard.layouts.app')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ __('Contact Details') }}</h3>
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
                    <a href="{{ route('dashboard.contacts.index') }}">{{ __('Contacts') }}</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ __('Contact Details') }}</a>
                </li>
            </ul>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('dashboard.contacts.index') }}" class="btn btn-secondary btn-round">{{ __('Back to Contacts') }}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ __('Contact Information') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-2"><strong>{{ __('Name') }}:</strong></div>
                            <div class="col-md-10">{{ $contact->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2"><strong>{{ __('Email') }}:</strong></div>
                            <div class="col-md-10">
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </div>
                        </div>
                        @if($contact->phone)
                        <div class="row mb-3">
                            <div class="col-md-2"><strong>{{ __('Phone') }}:</strong></div>
                            <div class="col-md-10">
                                <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                            </div>
                        </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-md-2"><strong>{{ __('Message') }}:</strong></div>
                            <div class="col-md-10">
                                <div class="p-3 bg-light rounded" style="white-space: pre-wrap;">{{ $contact->message }}</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2"><strong>{{ __('Submitted At') }}:</strong></div>
                            <div class="col-md-10">{{ $contact->created_at->format('F d, Y \a\t g:i A') }}</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('dashboard.contacts.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        <a href="#" class="btn btn-danger" onclick="$(this).next().submit()">{{ __('Delete') }}</a>
                        <form action="{{ route('dashboard.contacts.destroy', $contact->id) }}" method="POST"
                              onsubmit="return confirm('{{ __('Are You Sure?') }}')" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

