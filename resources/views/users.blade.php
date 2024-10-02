@extends('layouts.master')
@section('title')
    @lang('translation.contacts')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i
                                    class="ri-add-fill me-1 align-bottom"></i>@lang('translation.addUser')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-12">
            <div class="card" id="contactList">
                <div class="card-header">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for contact...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3" style='min-height:60vh;'>
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <!-- <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th> -->
                                        <th class="sort" data-sort="name" scope="col">@lang('translation.fullName')</th>
                                        <th class="sort" data-sort="email" scope="col">@lang('translation.email')</th>
                                        <th  data-sort="email_id" scope="col">@lang('translation.city')</th>
                                        <th data-sort="phone" scope="col">@lang('translation.role')</th>
                                        <th data-sort="tags" scope="col">@lang('translation.gender')</th>
                                        <th scope="col">@lang('translation.action')</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach($users as $cont)
                                    <tr>
                                        <!-- <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child"
                                                    value="option1">
                                            </div>
                                        </th> -->
                                        @php
                                            $name = $cont->name;
                                            $words = explode(' ', $name);
                                            if(count($words) >= 2){
                                                $initials = substr($words[0], 0, 1) . substr($words[1], 0, 1);
                                            }else{
                                                $initials = substr($name, 0, 1);
                                            }
                                        @endphp
                                        <td class="id" style="display:none;">{{ $cont->id }}</td>
                                        <td class="name">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 ms-2 name" data-letters="{{ $initials }}">{{ $cont->name }}</div>
                                            </div>
                                        </td>
                                        <td class="email">{{ $cont->email }}</td>
                                        <td class="address text-wrap">{{ $cont->city }}</td>
                                        <td class="phone">{{ $cont->role }}</td>
                                        <td class="tags-{{$cont->id}}">
                                            <span class="badge bg-primary-subtle text-primary">{{ $cont->gender }}</span>
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item">
                                                    <div class="dropdown">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item view-item-btn"
                                                                    href="{{ url('/users/'.$cont->id) }}"><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>@lang('translation.view')</a>
                                                            </li>
                                                            <li><a class="dropdown-item edit-item-btn" href="#showModal"
                                                                    data-bs-toggle="modal"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                    @lang('translation.edit')</a></li>
                                                            <li><a class="dropdown-item remove-item-btn"
                                                                    data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                    @lang('translation.delete')</a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if(count($users) == 0)
                                    <tr>
                                        <td colspan="7" style="text-align: center; vertical-align: middle;">
                                            <h2>@lang('translation.NoResultWasFound')</h2>
                                            <p class='text-muted'>
                                                @lang('translation.noresultMessage')
                                            </p>

                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ contacts We did not find any
                                        contacts for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    @lang('translation.previous')
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    @lang('translation.next')
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-info-subtle p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">@lang('translation.addUser')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                
                                <form class="tablelist-form m-3" id="add-user" novalidate 
                                    enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">@lang('translation.email') <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" id="useremail"
                                            placeholder="@lang('translation.enterEmail')" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="invalid-feedback">
                                            @lang('translation.enterEmail')
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-6">
                                            <label for="username" class="form-label">@lang('translation.fullName')<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" value="{{ old('name') }}" id="username"
                                                placeholder="@lang('translation.enterFullName')" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="invalid-feedback">
                                                @lang('translation.enterFullName')
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex flex-column ">
                                                <label for="arabName" class="form-label float-end"><span class='text-danger'>*</span>@lang('translation.fullNameInArab')</label>
                                                <input type="text" id="arabName" value="{{ old('arabName') }}" required
                                                    name="arabName" class="form-control text-rtl @error('arabName') is-invalid @enderror" 
                                                    placeholder="@lang('translation.enterFullNameInArab')">
                                            @error('arabName')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="invalid-feedback">
                                                @lang('translation.enterFullNameInArab')
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-6">
                                            <label class="form-label">@lang('translation.gender')</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input  class="form-check-input @error('gender') is-invalid @enderror" required  type="radio" name="gender" id="inlineRadio1" value="Male">
                                                    <label class="form-check-label" for="inlineRadio1">@lang('translation.male')</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror" required type="radio" name="gender" id="inlineRadio2" value="Female">
                                                    <label class="form-check-label" for="inlineRadio2">@lang('translation.female')</label>
                                                </div>
                                                @error('gender')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label  class="form-label m-0 p-0">
                                                    @lang('translation.role')
                                            </label>
                                            <select  name="role"  class='form-control' >
                                                <option value="Admin" selected>Amdin</option>
                                                <option value="SuperAdmin" >SuperAdmin</option>
                                                <option value="Lawyer" >lawyer</option>
                                                <option value="Assistant" >Assistant</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-6">
                                            <label for="city" class="form-label">@lang('translation.city')<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('city') is-invalid @enderror" name="city"
                                                id="city" placeholder="@lang('translation.enterCity')" required>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="invalid-feedback">
                                                @lang('translation.enterCity')
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex flex-column ">
                                                <label for="arabCity" class="form-label float-end"><span class='text-danger'>*</span>@lang('translation.cityInArab')</label>
                                                <input type="text" id="arabCity" value="{{ old('arabCity') }}" required
                                                    name="arabCity" class="form-control text-rtl @error('arabCity') is-invalid @enderror" 
                                                    placeholder="@lang('translation.enterCityInArab')">
                                            @error('arabCity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="invalid-feedback">
                                                @lang('translation.enterCityInArab')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword" class="form-label">@lang('translation.password') <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" 
                                                name="password"
                                                class="form-control password-input pe-5 @error('password') is-invalid @enderror"  
                                                placeholder="@lang('translation.enterPassword')" 
                                                id="password-input" 
                                                value="" 
                                            >
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" 
                                                    id="password-addon">
                                                <i class="ri-eye-fill align-middle"></i>
                                            </button>
                                            <div class="invalid-feedback">
                                                @lang('translation.enterVaildPass')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword" class="form-label">@lang('translation.password') <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" 
                                                name="password_confirmation"
                                                class="form-control password-input pe-5 @error('confirm-password') is-invalid @enderror"  
                                                placeholder="@lang('translation.enterPassword')" 
                                                id="password-input" 
                                                value=""
                                            >
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" 
                                                    type="button" 
                                                    id="password-addon">
                                                <i class="ri-eye-fill align-middle"></i>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="flex gap-3 float-left">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                                        <button type="submit" id="add-userBtn" class="btn btn-success" >@lang('translation.addUser')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end add modal-->

                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" id="deleteRecord-close"
                                        data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                        <h4>@lang('translation.deleteMessage') @lang('translation.client')</h4>
                                        <p class="text-muted mx-4 mb-0">@lang('translation.deleteConfirmation')</p>
                                    </div>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none"
                                            id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                class="ri-close-line me-1 align-middle"></i>@lang('translation.close')</button>
                                        <button class="btn btn-danger" id="delete-record">@lang('translation.yesDoIt')</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end delete modal -->

                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->

        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script>
        $("#add-user").on('submit', (e)=>{
            e.preventDefault()
            console.log("hello")
            const form = e.target
            const email = form.elements['email'].value
            const role = form.elements['role'].value
            const name = form.elements['name'].value
            const arabName = form.elements['arabName'].value
            const gender = form.elements['gender'].value
            const city = form.elements['city'].value
            const arabCity = form.elements['arabCity'].value
            const password = form.elements['password'].value
            const confirmPass = form.elements['password_confirmation'].value
            const data = {email, name, arabName, gender, city, arabCity, password, password_confirmation:confirmPass, role}
            console.log(token);
            $.ajax({
                url: "/users",
                method: "POST",
                contentType: 'application/json',
                data: JSON.stringify(data),
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: (res)=>{
                    window.location.reload()
                    toastr[res['alert-type']](res.message)
                },
                error: (xhr, status, error)=>{
                    $('#add-userBtn').html(``)
                    $('#add-userBtn').text("{{ __('translation.addUser') }}")
                    const err = xhr.responseJSON.errors
                    for(const key in err){
                        const input = e.target.elements[key] 
                        if(err[key][0].split('.')[1] === 'required'){
                            input.classList.add('is-invalid');
                            $(input).next('.invalid-feedback').html(`<strong>this field are required</strong>`);
                        }else if(err[key][0].split('.')[1] === 'unique'){
                            input.classList.add('is-invalid');
                            $(input).next('.invalid-feedback').html(`<strong>this field should be unique </strong>`);
                        }else{
                            input.classList.add('is-invalid');
                            $(input).next('.invalid-feedback').html(`<strong>${err[key]}</strong>`);
                        }
                    }
                }
            })
        });
    </script>
    <!-- <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/crm-contact.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script> -->
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection
