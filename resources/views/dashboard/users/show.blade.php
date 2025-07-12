@extends('dashboard.layouts.app')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ __('Show user') }}</h3>
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
                    <a href="{{ route('dashboard.users.index') }}">{{ __('Users') }}</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ __('Show user') }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-header" style="background-image: url('assets/img/blogpost.jpg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <img src="{{ asset('/dashboard/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">{{ $user->name }}, 19</div>
                            <div class="job">{{ $user->role }}</div>
                            <div class="desc">{{ $user->email }}</div>
                            <div class="social-media">
                                <a class="btn btn-info btn-twitter btn-sm btn-link" href="#">
                          <span class="btn-label just-icon"><i class="icon-social-twitter"></i>
                          </span>
                                </a>
                                <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#">
                          <span class="btn-label just-icon"><i class="icon-social-facebook"></i>
                          </span>
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                          <span class="btn-label just-icon"><i class="icon-social-instagram"></i>
                          </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="number">125</div>
                                <div class="title">Post</div>
                            </div>
                            <div class="col">
                                <div class="number">25K</div>
                                <div class="title">Followers</div>
                            </div>
                            <div class="col">
                                <div class="number">134</div>
                                <div class="title">Following</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
