@extends('layouts.master')
@section('title')
    @lang('translation.analytics')
@endsection
@section('css')
    <!-- <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.dashboards')
        @endslot
        @slot('title')
            @lang('translation.documents')
        @endslot
    @endcomponent
    <!-- Rounded with Label -->
<div class="card mb-5">
            
    <div class="card-body">
        <div class="listjs-table" id="customerList">
            <div class="row g-4 mb-3">
                <div class="col-sm-auto">
                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                        id="create-btn" data-bs-target="#showModal"><i
                            class="ri-add-line align-bottom me-1"></i>@lang('translation.addDocument')</button>
                        <button class="btn btn-soft-danger " onClick="deleteMultiple()"><i
                                class="ri-delete-bin-2-line"></i></button>
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
                <table class="table align-middle table-nowrap  table-hover" id="customerTable" id='myTable'>
                    <thead class="table-light">
                        <tr class= 'text-center' >
                            <th scope="col" style="width: 50px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        value="option">
                                </div>
                            </th>
                            <th class="sort text-black px-2 m-0" data-sort="id">Id</th>
                            <th class="sort" data-sort="name">@lang('translation.fileName')</th>
                            <th >@lang('translation.file_description')</th>
                            <th >@lang('translation.case')</th>
                            <th >@lang('translation.createAt')</th>
                            <th >@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                        value="option1">
                                </div>
                            </th>
                            <td class="id"><a href="javascript:void(0);"
                                        class="fw-medium link-primary">...</a></td>
                            <td class="name text-center">...</td>
                            <td class="file_desc text-wrap">...</td>
                            <td class="case text-wrap ">... </td>
                            <td class="date text-wrap ">... </td>
                            <td class=''>
                                <div class="d-flex gap-2">
                                    <div class="view">
                                        <button class="btn btn-sm btn-primary view-btn">
                                                <i class='ri-eye-fill align-middle'></i>
                                        </button>
                                    </div>
                                    <div class="download">
                                        <button class="btn btn-sm btn-light download-btn">
                                                <i class='las la-download'></i>
                                        </button>
                                    </div>
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
                            @lang('translation.previous')
                        </a>
                        <ul class="pagination listjs-pagination mb-0"></ul>
                        <a class="page-item pagination-next" href="javascript:void(0);">
                            @lang('translation.next')
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
                                    <label for="name" class="form-label">@lang("translation.fileName")</label>
                                    <input type="text"  name='name' required class="form-control" id="name-field" placeholder="@lang('translation.enterFileName')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="file_desc" class="form-label">@lang("translation.file_description")</label>
                                    <textarea rows='3' type="text"  name='file_desc' class="form-control" id="file_desc-field" placeholder="@lang('translation.enterFileDesc')"></textarea>
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label for="case" class="form-label">@lang("translation.case")</label>
                                <select  data-choices name="case" 
                                id="case-field"  class='form-control '>
                                    <option value="">@lang('translation.selectCase')</option>
                                    @foreach($cases as $case)
                                        <option value="{{ $case->id }}">{{ $case->title_file }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div class="card-body" >
                                    <p class="text-muted">@lang("translation.fileMessage").</p>
                                    <input type="file" class="filepond filepond-input-multiple" id='docs' name="docs"
                                        data-allow-reorder="true" data-max-files="3">
                                </div>
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div><!--end col-->
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">@lang('translation.addJudge')</button>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                </div>
                            </div>
                        </div><!--end row-->
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!--  deleter modal -->

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
                            <h4>@lang('translation.deleteMessage') @lang('translation.case')</h4>
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
            addDocument: "{{ __('translation.addDocument') }}",
            editDocument: "{{ __('translation.editDocument') }}",
            male: "{{ __('translation.male') }}",
            female: "{{ __('translation.female') }}",
            selectCase: "{{ __('translation.selectCase') }}",
            yes: "{{ __('translation.yes') }}",
        }

    </script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
    <!-- <script src="{{ URL::asset('build/js/pages/form-file-upload.init.js') }}"></script> -->

    <script src="{{ URL::asset('build/js/pages/documentList.init.js') }}"></script>

    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection