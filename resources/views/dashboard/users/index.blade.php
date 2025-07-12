@extends('dashboard.layouts.app')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">{{ __('Users') }}</h3>
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
                    <a href="#">{{ __('Users') }}</a>
                </li>
            </ul>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary btn-round">{{ __('Add user') }}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ __('Users') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table mt-3">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Role') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.users.show', $user->id) }}"
                                           class="text-info me-2"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                           class="text-success me-2"><i class="fa fa-pencil-alt"></i></a>
                                        <a href="#" class="text-danger" onclick="$(this).next().submit()"><i
                                                class="fa fa-trash"></i></a>
                                        <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('{{ __('Are You Sure?') }}')">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
