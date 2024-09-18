@extends('layouts.master')
@section('title')
    @lang('translation.contacts')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            CRM
        @endslot
        @slot('title')
            Contacts
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i
                                    class="ri-add-fill me-1 align-bottom"></i>@lang('translation.addContact')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-9">
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
                                        <th  data-sort="email_id" scope="col">@lang('translation.address')</th>
                                        <th data-sort="phone" scope="col">@lang('translation.phone')</th>
                                        <th data-sort="tags" scope="col">@lang('translation.tags')</th>
                                        <th scope="col">@lang('translation.action')</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach($contacts as $cont)
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
                                        <td class="address text-wrap">{{ $cont->address }}</td>
                                        <td class="phone">{{ $cont->phone }}</td>
                                        <td class="tags-{{$cont->id}}">
                                            @foreach(json_decode($cont->tag) as $tag)
                                                <span class="badge bg-primary-subtle text-primary" id='{{$tag}}'>@lang('translation.' .$tag)</span>
                                            @endforeach
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
                                                                    href="{{ url('/contact/'.$cont->id) }}"><i
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
                                    @if(count($contacts) == 0)
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
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field" />
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                
                                                <div>
                                                    <label for="name-field" class="form-label">@lang('translation.fullName')</label>
                                                    <input type="text" id="customername-field" class="form-control"
                                                        placeholder=" @lang('translation.enterFullName') " required />
                                                </div>
                                            </div>
                                           
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="email_id-field" class="form-label">@lang('translation.email')</label>
                                                    <input type="text" id="email_id-field" class="form-control"
                                                        placeholder="@lang('translation.enterEmail')" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="phone-field" class="form-label">@lang('translation.phone')</label>
                                                    <input type="text" id="phone-field" class="form-control"
                                                        placeholder="@lang('translation.enterPhone')" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="address-field" class="form-label">@lang('translation.address')</label>
                                                    <input type="text" id="address-field" class="form-control"
                                                        placeholder="@lang('translation.enterAddress') " required />
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="taginput-choices"
                                                        class="form-label font-size-13 text-muted">@lang('translation.tag')</label>
                                                    <select class="form-control" name="taginput-choices"
                                                        id="taginput-choices" multiple>
                                                        <option value="Company">@lang('translation.Company')</option>
                                                        <option value="Partner">@lang('translation.Partner')</option>
                                                        <option value="Assistant">@lang('translation.Assistant')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">@lang('translation.close')</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">@lang('translation.addContact')</button>
                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                        </div>
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
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/crm-contact.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
