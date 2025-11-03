@extends('dashboard.layouts.app')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">{{ __('Email Subscribers') }}</h3>
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
                    <a href="#">{{ __('Email Subscribers') }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ __('Email Subscribers') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table mt-3">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Subscribed At') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subscribers as $subscriber)
                                <tr>
                                    <td>{{ $subscriber->id }}</td>
                                    <td>{{ $subscriber->email }}</td>
                                    <td>{{ $subscriber->created_at->format('F d, Y \a\t g:i A') }}</td>
                                    <td>
                                        <a href="#" class="text-danger" onclick="$(this).next().submit()"><i
                                                class="fa fa-trash"></i></a>
                                        <form action="{{ route('dashboard.subscribers.destroy', $subscriber->id) }}" method="POST"
                                              onsubmit="return confirm('{{ __('Are You Sure?') }}')">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('No subscribers found.') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $subscribers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

