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

    <div class="row mt-5">
        
        <div class="col-xxl-12">
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
                                                placeholder="@lang('translation.enterFullName')" name='name' required value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 my-2">
                                        <div class="mb-3">
                                            <label for="arabFullName" class="form-label">@lang('translation.fullNameInArab')</label>
                                            <input type="text" class="form-control" id="arabFullName"
                                                placeholder="@lang('translation.enterFullNameInArab')" required name='name_in_arab' value="{{ Auth::user()->name_in_arab }}">
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
                                            <input type="email" class="form-control" id="emailInput" required  name='email'
                                                placeholder="@lang('translation.enterEmail')" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <div class="mb-3">
                                            <label for="cityInput" class="form-label">@lang('translation.city')</label>
                                            <input type="text" class="form-control" id="cityInput" required  name='city' placeholder="@lang('translation.enterCity')"
                                                value="{{ Auth::user()->city }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <div class="mb-3">
                                            <label for="arabCity" class="form-label">@lang('translation.cityInArab')</label>
                                            <input type="text" class="form-control" id="arabCity" required name='city_in_arab' placeholder="@lang('translation.enterCityInArab')"
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
                             <form method="post"  id='updatePassword' class="mt-6 space-y-6">
                                @csrf
                                @method('put')
                                <div class="row g-2 ">
                                    <div class="col-lg-4 my-2">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">@lang('translation.oldPassword')*</label>
                                            <input type="password" name='current_password' class="form-control" id="oldpasswordInput"
                                                placeholder="@lang('translation.enterOldPass')">
                                            <span class="invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4 my-2">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">@lang('translation.newPassword')*</label>
                                            <input type="password" name='password' class="form-control" id="newpasswordInput"
                                                placeholder="@lang('translation.enterNewPass')">
                                            <span class="invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4 my-2">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">@lang('translation.confirmPassword')*</label>
                                            <input type="password" name='password_confirmation' class="form-control" id="confirmpasswordInput"
                                                placeholder="@lang('translation.confirmPass')">
                                            <span class="invalid-feedback" role="alert"></span>
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
    </div>
    <!--end row-->
@endsection
@section('script')
    <script>
        $("#updatePassword").on('submit', function(e){
            e.preventDefault()
            const form = e.target;
            let curPass = form.elements['current_password'].value
            let newPass = form.elements['password'].value
            let confirm = form.elements['password_confirmation'].value

            if(curPass === "" && newPass === "" && confirm === ""){
                toastr['error']("@lang('translation.fillAllField')")
            }else{
                console.log(newPass, confirm)
                if(newPass !== confirm){
                    $('#newpasswordInput').addClass('is-invalid')
                    $('.invalid-feedback').html(`<strong>@lang('translation.passwordDoesntMatch')</strong>`);
                    $('#confirmpasswordInput').val('')
                }else{
                    const inputs = {
                        current_password : curPass,
                        password: newPass,
                        password_confirmation: confirm
                    }
                    console.log(inputs)
                    $.ajax({
                        url: '{{ route("password.update") }}',
                        method: "PUT",
                        headers:{
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        data: JSON.stringify(inputs),
                        success: (res)=>{
                            toastr[res['alert-type']](res.message)
                            $('#confirmpasswordInput').val('')
                            $('#confirmpasswordInput').removeClass('is-invalid')
                            $('#newpasswordInput').val('')
                            $('#newpasswordInput').removeClass('is-invalid')
                            $('#oldpasswordInput').val('')
                            $('#oldpasswordInput').removeClass('is-invalid')
                            $('.invalid-feedback').html(``);
                        },
                        error: (xhr, status, error)=>{
                            const err = xhr.responseJSON.errors
                            for(const key in err){
                                const input = form.elements[key] 
                                if(err[key][0].split('.')[1] === 'current_password'){
                                    input.classList.add('is-invalid');
                                    $(input).next('.invalid-feedback').html(`<strong>@lang('translation.incorecctPass')</strong>`);
                                }else if(err[key][0].split('.')[1] === 'min.string'){
                                    input.classList.add('is-invalid');
                                    $(input).next('.invalid-feedback').html(`<strong>@lang('translation.minPass')</strong>`);
                                }else{
                                    input.classList.add('is-invalid');
                                    $(input).next('.invalid-feedback').html(`<strong>@lang('translation.someError')</strong>`);
                                }
                            }

                            // $('newpasswordInput').addClass('is-invalid')
                            // $('.invalid-feedback').html(`<strong>passwod does't match</strong>`);
                            // $('newpasswordInput').val('')
                            // $('confirmpasswordInput').val('')
                        }
                    })
                }

            }

        })
    </script>
    <script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
