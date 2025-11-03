@extends('dashboard.layouts.app')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">{{ __('Contacts') }}</h3>
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
                    <a href="#">{{ __('Contacts') }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ __('Contacts') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table mt-3">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Phone') }}</th>
                                <th scope="col">{{ __('Submitted At') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone ?? __('N/A') }}</td>
                                    <td>{{ $contact->created_at->format('F d, Y \a\t g:i A') }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.contacts.show', $contact->id) }}"
                                           class="text-info me-2"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="text-danger" onclick="$(this).next().submit()"><i
                                                class="fa fa-trash"></i></a>
                                        <form action="{{ route('dashboard.contacts.destroy', $contact->id) }}" method="POST"
                                              onsubmit="return confirm('{{ __('Are You Sure?') }}')">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No contacts found.') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

