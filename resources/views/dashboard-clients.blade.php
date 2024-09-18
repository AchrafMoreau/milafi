@extends('layouts.master')
@section('title')
    @lang('translation.analytics')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .firstRaw{
        display:none;
        background: red;
    }
</style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Clients
        @endslot
    @endcomponent
    <!-- Rounded with Label -->

<div class="card mb-5">
            
    <div class="card-body">
        <div class="listjs-table" id="customerList">
            <div class="row g-4 mb-3">
                <div class="col-sm-auto">
                    <div>
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                            id="create-btn" data-bs-target="#showModal"><i
                                class="ri-add-line align-bottom me-1"></i>@lang('translation.addclient')</button>
                        <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                class="ri-delete-bin-2-line"></i></button>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="d-flex justify-content-sm-end">
                        <div class="search-box ms-2">
                            <input type="text" class="form-control search" placeholder="Search...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

          

                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap" id="customerTable">
                        <thead class="table-light">
                            <tr class='text-center'>
                                <th scope="col" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                            value="option">
                                    </div>
                                </th>
                            <th class="sort" data-sort="name" >@lang('translation.name')</th>
                            <th  data-sort="contact">@lang('translation.contact')</th>
                            <th class=" px-3" data-sort="gender" >@lang('translation.gender')</th>
                            <th class=" px-3 text-break" data-sort="CIN" >@lang('translation.CIN')</th>
                            <th class='address'  data-sort='address'>@lang('translation.address')</th>
                            <th data-sort="case" >@lang('translation.cases')</th>
                            <th >@lang('translation.action')</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            <tr id='firstRaw'>
                                <th scope="row">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="chk_child"
                                            value="option1">
                                    </div>
                                </th>
                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                        class="fw-medium link-primary">test</a></td>
                                <td class="name">...</td>
                                <td class="contact">...</td>
                                <td class="gender">...</td>
                                <td class="CIN">...</td>
                                <td class="address">...</td>
                                <td class="case"><span
                                        class="badge bg-success-subtle text-success text-uppercase">0</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <button class="btn btn-sm btn-success edit-item-btn"
                                                data-bs-toggle="modal" data-bs-target="#showModal">
                                                    <i class="ri-pencil-fill align-bottom"></i>
                                            </button>
                                        </div>
                                        <div class="remove">
                                            <button class="btn btn-sm btn-danger remove-item-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteRecordModal">
                                                <i class="ri-delete-bin-5-fill align-bottom"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="noresult" style="display: none">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                            </lord-icon>
                            <h5 class="mt-2">@lang('translation.NoResultWasFound')</h5>
                            <p class="text-muted mb-0">@lang('translation.searchNotFound')</p>
                        </div>
                    </div>
                </div>

            <div class="d-flex justify-content-end">
                <div class="d-flex justify-content-end">
                    <div class="pagination-wrap hstack gap-2">
                        <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                            Previous
                        </a>
                        <ul class="pagination listjs-pagination mb-0"></ul>
                        <a class="page-item pagination-next" href="javascript:void(0);">
                            Next
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end card -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
            
                
                <div class="modal-body">
                    <form class="tablelist-form" autocomplete="off">
                        <div class="row g-3">
                            <div class="mb-3" id="modal-id" style="display: none;">
                                <label for="id-field" class="form-label">ID</label>
                                <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                            </div>
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">@lang('translation.fullName')</label>
                                    <input type="text" required name='name' value='{{ old("name") }}' class="form-control  " id="name-field" placeholder="@lang('translation.enterFullName')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label class="form-label">@lang('translation.gender')</label>
                                <div id='gender-field'>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"  type="radio" name="gender" id="gender-male" value="male">
                                        <label value="{{ old('gender') }}" class="form-check-label " for="gender-male">@lang('translation.male')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender-female" value="female">
                                        <label value="{{ old('gender') }}" class="form-check-label " for="gender-female">@lang('translation.female')</label>
                                    </div>
                                </div>
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="CIN" class="form-label">@lang('translation.CIN')</label>
                                <input type="text" value="{{ old('CIN') }}" required class="form-control " name='CIN' id="cin-field" placeholder="@lang('translation.enterCIN')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="contact" class="form-label">@lang('translation.contact')</label>
                                <input type="text" value="{{ old('contact') }}" required class="form-control "  name='contact_info' id="contact_info-field" placeholder="@lang('translation.enterContact')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="address" class="form-label">@lang('translation.address')</label>
                                <input type="text" value="{{ old('address') }}" class="form-control " id="address-field" name='address' placeholder="@lang('translation.enterAddress')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">@lang('translation.addclient')</button>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                </div>
                            </div>
                        </div><!--end row-->
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>@lang('translation.deleteMessage') @lang('translation.client')</h4>
                            <p class="text-muted mx-4 mb-0">@lang('translation.deleteConfirmation')</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                        <button type="button" class="btn w-sm btn-danger " id="delete-record">@lang('translation.yes')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>




  

<!-- end table responsive -->
@endsection
@section('script')
    <script>
        window.translations = {
            addClient: "{{ __('translation.addclient') }}",
            editClient: "{{ __('translation.editClient') }}",
            male: "{{ __('translation.male') }}",
            female: "{{ __('translation.female') }}",
            selectCourt: "{{ __('translation.selectCourt') }}",
            update: "{{ __('translation.update') }}",
            yes: "{{ __('translation.yes') }}",
        }
    </script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
    
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!-- listjs init -->
    <script src="{{ URL::asset('build/js/pages/clientList.init.js') }}"></script>

    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/5fff77269d.js" crossorigin="anonymous"></script>
@endsection

