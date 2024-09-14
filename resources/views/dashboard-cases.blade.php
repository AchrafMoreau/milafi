@extends('layouts.master')
@section('title')
    @lang('translation.analytics')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Cases
        @endslot
    @endcomponent
    <!-- Rounded with Label -->
<div class="card mb-5">
            
    <div class="card-body">
        <div class="listjs-table" id="customerList">
            <div class="row g-4 mb-3">
                <div class="col-sm-auto">
                    <div class="d-flex justify-content-sm-end">
                        <div class="search-box ms-2">
                            <input type="text" class="form-control search" placeholder="Search...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class='d-flex gap-2 justify-content-sm-end'>
                        <button class="btn btn-soft-danger " onClick="deleteMultiple()"><i
                                class="ri-delete-bin-2-line"></i></button>
                        <a href="{{ url('/case-add') }}">
                        <button type="button" class="btn btn-primary add-btn" >
                                <i class="fa-solid fa-folder-plus"></i>
                                    @lang('translation.addcase')
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive table-card mt-3 mb-1">
                <table class="table align-middle table-hover" id="customerTable">
                    <thead class="table-light">
                        <tr class= 'text-center' >
                            <th scope="col" style="width: 50px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        value="option">
                                </div>
                            </th>
                            <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">test</a></td>
                            <th class="sort text-black px-2 m-0" data-sort="serial_number">S.N</th>
                            <th  class="sort" data-sort="name">@lang('translation.caseTitle')</th>
                            <th  class='sort' data-sort="client">@lang('translation.client')</th>
                            <th class=" px-3" data-sort="court">@lang('translation.court')</th>
                            <th class='judge'>@lang('translation.judge')</th>
                            <th class="sort" data-sort="status">@lang('translation.status')</th>
                            <th>@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                            <tr class='parent'>
                                 
                                <th scope="row" >
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="chk_child"
                                            value="option1">
                                    </div>
                                </th>
    
                                <td class="id" style='display:none;'  ><a href="javascript:void(0);"
                                        class="fw-medium link-primary">test</a></td>
                                <td class="serial_number" >......</td>
                                <td class="name"><span class='test'></span>......</td>
                                <td class="client word-wrap">......</td>
                                <td class="court text-wrap">......</td>
                                <td class="judge">......</td>
                                <!-- Dropdown Variant -->
                                <td class="status" >
                                    <button type="button" data-bs-toggle="dropdown" id='st2' aria-haspopup="true" aria-expanded="false" class="btn btn-sm dropdown-toggle bg-success-subtle text-success" >@lang('translation.Open')
                                    </button>
                                    <div class="dropdown-menu cursor-pointer">
                                        <a class="dropdown-item" onclick="handleStatusChange('Pending', 2)">@lang('translation.Pending')</a>
                                        <a class="dropdown-item" onclick="handleStatusChange('Closed', 2)">@lang('translation.Closed')</a>
                                        <a class="dropdown-item" onclick="handleStatusChange('Open', 2)">@lang('translation.Open')</a>
                                    </div>
                                </td>
                               <td >
                                    <div class="d-flex gap-2">
                                    
                                        <div class="edit">
                                            <button class='btn btn-sm btn-success'>
                                                <i class="ri-pencil-fill align-bottom"></i>
                                            </button>
                                        </div>
                                        <div class="view">
                                            <button class="btn btn-sm btn-primary" >
                                                <i class='ri-eye-fill align-middle'></i>
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
    </div><!-- end card -->

</div>

  

<!-- end table responsive -->
@endsection
@section('script')
    <script>
        window.translations = {
            open: "{{ __('translation.Open') }}",
            closed: "{{ __('translation.Closed') }}",
            pending: "{{ __('translation.Pending') }}"
        }
    </script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>


    <!-- listjs init -->
    <script src="{{ URL::asset('build/js/pages/CaseList.init.js') }}"></script>

    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/5fff77269d.js" crossorigin="anonymous"></script>
    <script>
        const handleStatusChange =(e, id)=>{
            let translations = {
                open: "{{ __('translation.Open') }}",
                closed: "{{ __('translation.Closed') }}",
                pending: "{{ __('translation.Pending') }}"
            };
            $.ajax({
                url: `/status/${id}`,
                method: "POST",
                data: JSON.stringify({ status: e }),
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                success: (res) => {
                    let btn = $(`#${id}`);
                    btn.removeClass()
                    if(res.status == 'Open'){
                        btn.addClass('btn btn-sm dropdown-toggle bg-success-subtle text-success ');
                        btn.text(translations.open)
                    }else if(res.status == 'Closed'){
                        btn.addClass('btn btn-sm dropdown-toggle bg-danger-subtle text-danger ');
                        btn.text(translations.closed)
                    }else{
                        btn.addClass('btn btn-sm dropdown-toggle bg-primary-subtle text-primary ');
                        btn.text(translations.pending)
                    }

                    toastr[res['alert-type']](res.message)

                },
                error: (xhr,status, error) => console.log(error)
            })
        }
        // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const handleCase = (id)=>{
            fetch('/cas/'+id,{
                method: "GET",
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
        }
    </script>
@endsection
