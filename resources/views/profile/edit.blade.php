@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  maybe not today mybe not tommorow but some day  -->
    <!-- <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ URL::asset('build/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            <i class="ri-image-edit-line align-bottom me-1"></i>@lang('translation.changeBackground')
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-xxl-3">
            <!-- <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }}@else{{ URL::asset('build/images/users/avatar-1.jpg') }} @endif"
                                class="  rounded-circle avatar-xl img-thumbnail user-profile-image"
                                alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted mb-0">{{ Auth::user()->role }}</p>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                @lang('translation.personalDetails')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                @lang('translation.changePassword')
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form  method="post" action="{{ route('profile.update') }}">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-lg-6 my-2">
                                        <div class="mb-3">
                                            <label for="firstnameInput" class="form-label">@lang('translation.fullName')</label>
                                            <input type="text" class="form-control" id="firstnameInput"
                                                placeholder="@lang('translation.enterFullName')" name='name' value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 my-2">
                                        <div class="mb-3">
                                            <label for="arabFullName" class="form-label">@lang('translation.fullNameInArab')</label>
                                            <input type="text" class="form-control" id="arabFullName"
                                                placeholder="@lang('translation.enterFullNameInArab')" name='name_in_arab' value="{{ Auth::user()->name_in_arab }}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6 my-2">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">@lang('translation.phone')</label>
                                            <input type="text" class="form-control" id="phonenumberInput"
                                                placeholder="@lang('translation.enterContact')" name='phone' value="{{ Auth::user()->phone }}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6 my-2">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">@lang('translation.email')</label>
                                            <input type="email" class="form-control" id="emailInput" name='email'
                                                placeholder="@lang('translation.enterEmail')" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <div class="mb-3">
                                            <label for="cityInput" class="form-label">@lang('translation.city')</label>
                                            <input type="text" class="form-control" id="cityInput" name='city' placeholder="@lang('translation.enterCity')"
                                                value="{{ Auth::user()->city }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <div class="mb-3">
                                            <label for="arabCity" class="form-label">@lang('translation.cityInArab')</label>
                                            <input type="text" class="form-control" id="arabCity" name='city_in_arab' placeholder="@lang('translation.enterCityInArab')"
                                                value="{{ Auth::user()->city_in_arab }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 my-2">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-secondary">@lang('translation.update')</button>
                                            <!-- <button type="button" class="btn btn-soft-danger">@lang('translation.close')</button> -->
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                             <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')
                                <div class="row g-2 ">
                                    <div class="col-lg-4 my-2">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">@lang('translation.oldPassword')*</label>
                                            <input type="password" name='current_password' class="form-control" id="oldpasswordInput"
                                                placeholder="@lang('translation.enterOldPass')">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4 my-2">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">@lang('translation.newPassword')*</label>
                                            <input type="password" name='password' class="form-control" id="newpasswordInput"
                                                placeholder="@lang('translation.enterNewPass')">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4 my-2">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">@lang('translation.confirmPassword')*</label>
                                            <input type="password" name='password_confirmation' class="form-control" id="confirmpasswordInput"
                                                placeholder="@lang('translation.confirmPass')">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    
                                    <!--end col-->
                                    <div class="col-lg-12 my-2">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-secondary">@lang('translation.changePassword')</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div> -->
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
