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
                    <div class="col-sm">
                        <div class="d-flex justify-content-sm-end">
                            <div class="search-box ms-2">
                                <input type="text" class="form-control search" placeholder="Search...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ url('/case-add') }} " class='text-white'>
                            <button type="button" class="btn btn-primary">
                                <i class="fa-solid fa-folder-plus"></i>
                                    @lang('translation.addcase')
                            </button>
                        </a>
                        <!-- <button class="btn btn-soft-danger" type='button' onClick="deleteMultiple('case')"><i
                                class="ri-delete-bin-2-line"></i></button> -->
                    </div>

                </div>
            </div>

            <div class="table-responsive table-card mt-3 mb-1">
                <table class="table align-middle table-hover" id="customerTable">
                    <thead class="table-light">
                        <tr class= 'text-center' >
                            <!-- <th scope="col" style="width: 50px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        value="option">
                                </div>
                            </th> -->
                            <th class="sort text-black px-2 m-0" data-sort="id">S.N</th>
                            <th  class="sort" data-sort="client_name">@lang('translation.caseTitle')</th>
                            <th  class='sort' data-sort="contact">@lang('translation.client')</th>
                            <th class=" px-3" data-sort="gender">@lang('translation.court')</th>
                            <th class='address'>@lang('translation.judge')</th>
                            <th class="sort" data-sort="status">@lang('translation.status')</th>
                            <th >@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                            @foreach($cas as $case)
                            <tr >
                                 
                                <!-- <th scope="row">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="chk_child"
                                            value="option1">
                                    </div>
                                </th> -->

                                <td class="id">{{ $case->serial_number }}</td>
                                <td class="client_name word-wrap">{{ $case->title_file }}</td>
                                <td class="gender">{{ $case->client['name'] }}</td>
                                <td class="address text-wrap">{{ $case->court['name'] }} </td>
                                <td class="cases">{{ $case->judge['name'] }}</td>
                                <!-- Dropdown Variant -->
                                <td class="status">
                                    <button type="button" data-bs-toggle="dropdown" id='st{{$case->id}}' aria-haspopup="true" aria-expanded="false" class="btn btn-sm dropdown-toggle {{ $case->status == 'Open' ? 'bg-success-subtle text-success' : ($case->status == 'Closed' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary') }} " >@lang('translation.' . $case->status)
                                    </button>
                                    <div class="dropdown-menu cursor-pointer">
                                        <a class="dropdown-item" onclick="handleStatusChange('Pending', {{ $case->id}})">@lang('translation.Pending')</a>
                                        <a class="dropdown-item" onclick="handleStatusChange('Closed', {{ $case->id}})">@lang('translation.Closed')</a>
                                        <a class="dropdown-item" onclick="handleStatusChange('Open', {{ $case->id}})">@lang('translation.Open')</a>
                                    </div>
                                </td><!-- /btn-group -->
                                <!-- <td class="status"><span
                                    class="badge {{ $case->status == 'Open' ? 'bg-success-subtle text-success' : ($case->status == 'Closed' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary') }} text-uppercase" >{{ $case->status }}</span>
                                </td> -->
                                <td>
                                    <div class="d-flex gap-2">
                                    
                                        <div class="edite">
                                            <a href="{{ url('/case-edit/'.$case->id) }}">
                                                <button class='btn btn-sm btn-success'>
                                                    <i class="ri-pencil-fill align-bottom"></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="view">
                                            <a href="{{ url('cas/'.$case->id) }}">
                                                <button class="btn btn-sm btn-primary">
                                                    <i class='ri-eye-fill align-middle'></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="remove">
                                            <button type="button" id='{{ $case->id }}' class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal" data-bs-target="#modal-{{$case->id}}" >
                                                <i class="ri-delete-bin-5-fill align-bottom"></i>
                                            </button>
                                            <div class="modal fade bs-example-modal-center" id="modal-{{$case->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-5">
                                                            <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                                                                trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                                                            </lord-icon>
                                                            <div class="mt-4">
                                                                <h4 class="mb-3">@lang('translation.deleteMessage') @lang('translation.client') !</h4>
                                                                <p class="text-muted mb-4 text-wrap">@lang('translation.deleteConfirmation').</p>
                                                                <form action="{{ url('/case-delete/'.$case->id) }}" method='POST'  class="hstack gap-2 justify-content-center">
                                                                    @csrf
                                                                    @method("DELETE")
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                                                                    <button type='submit' class='btn btn-danger'>@lang('translation.yes')</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>
                                        </div>
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="noresult" style="display: none">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                        </lord-icon>
                        <h5 class="mt-2">Sorry! No Result Found</h5>
                        <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                            orders for you search.</p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="pagination-wrap hstack gap-2 d-flex flex-column">
                            {{ $cas->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div><!-- end card -->
</div>

  

<!-- end table responsive -->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>


    <!-- listjs init -->
    <script src="{{ URL::asset('build/js/pages/listjs.init.js') }}"></script>

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
                    let btn = $(`#st${id}`);
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

                    console.log(res.message)

                    toastr[res['alert-type']](res.message)

                },
                error: (xhr,status, error) => console.log(error)
            })
            console.log(e, id)
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
