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
                    @component('documents.add-document', ['cases' => $cases])
                    @endcomponent
                       
                    </div>

                </div>
            </div>

            <div class="table-responsive table-card mt-3 mb-1">
                <table class="table align-middle table-nowrap  table-hover" id="customerTable" id='myTable'>
                    <thead class="table-light">
                        <tr class= 'text-center' >
                            
                            <th class="sort text-black px-2 m-0" data-sort="id">Id</th>
                            <th class="sort" data-sort="client_name">@lang('translation.fileName')</th>
                            <th  data-sort="contact">@lang('translation.case')</th>
                            <th data-sort="cases">@lang('translation.createAt')</th>
                            <th >@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                            @foreach($docs as $doc)
                        <tr>
                            

                            <td class="id">000{{ $doc->id }}</td>
                            <td class="client_name text-center">{{ $doc->name }}</td>
                            <td class="contact text-center">{{ $doc->cas->title_file }}</td>
                            <td class="address text-wrap ">{{ $doc->created_at->diffForHumans() }} </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                
                                    <div class="edite">
                                        @component('documents.edit-document', ['doc'=> $doc, 'cases' => $cases])
                                        @endcomponent
                                    </div>
                                    <div class="view">
                                        <a href="{{ url('/show-doc/'.$doc->id) }}">
                                            <button type="button" class="btn btn-sm btn-primary">
                                                <i class='ri-eye-fill align-middle'></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="download">
                                        <a href="{{ url('/uploadFile/'.$doc->file_path) }}">
                                            <button class="btn btn-light btn-sm" type='button'>
                                                <i class='las la-download'></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="remove">
                                        <button type="button" id='{{ $doc->id }}' class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal" data-bs-target="#modal-{{$doc->id}}" >
                                            <i class=' las la-trash'></i>
                                        </button>
                                        <div class="modal fade bs-example-modal-center" id="modal-{{$doc->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center p-5">
                                                        <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                                                            trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                                                        </lord-icon>
                                                       <div class="mt-4">
                                                            <h4 class="mb-3 text-wrap">@lang('translation.deleteMessage') @lang('translation.document') !</h4>
                                                            <p class="text-muted mb-4 text-wrap">@lang('translation.deleteConfirmation').</p>
                                                            <form action="{{ url('/doc-delete/'.$doc->id) }}" method='POST'  class="hstack gap-2 justify-content-center">
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
                        <h5 class="mt-2">@lang('translation.NoResultWasFound')</h5>
                        <p class="text-muted mb-0">@lang('translation.searchNotFound')</p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="pagination-wrap hstack gap-2 d-flex flex-column">
                    {{ $docs->links('pagination::bootstrap-5') }}
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
    <!-- <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script> -->
    <script src="{{ URL::asset('build/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ URL::asset('build/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ URL::asset('build/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-file-upload.init.js') }}"></script>
    <script>
        function deleteMultiple(prop) {
        ids_array = [];
        var items = document.getElementsByName('chk_child');
        Array.from(items).forEach(function (ele) {
            if (ele.checked == true) {
            var trNode = ele.parentNode.parentNode.parentNode;
            var id = trNode.querySelector('.id').innerHTML;
            ids_array.push(id);
            }
        });
        if (typeof ids_array !== 'undefined' && ids_array.length > 0) {
            if (confirm('Are you sure you want to delete this?')) {
                console.log(ids_array)
                const url = '/destroyMany-'+ prop;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(url, {
                    method: "DELETE",
                    body: JSON.stringify({
                        "ids" : ids_array,  
                    }),
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    }
                })
                .then( data => window.location.reload())
                .catch(error => console.log(error));
            document.getElementById('checkAll').checked = false;
            } else {
            return false;
            }
        } else {
            Swal.fire({
            title: 'Please select at least one checkbox',
            confirmButtonClass: 'btn btn-info',
            buttonsStyling: false,
            showCloseButton: true
            });
        }
        }
    </script>
@endsection