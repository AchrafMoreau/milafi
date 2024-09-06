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
            Clients
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
                    @component('clients.add-client')
                    @endcomponent
                        <!-- <button class="btn btn-soft-danger" onClick="deleteMultiple('client')"><i
                                class="ri-delete-bin-2-line"></i></button> -->
                    </div>

                </div>
            </div>

            <div class="table-responsive table-card mt-3  mb-1">
                <table class="table align-middle table-nowrap table-hover" id="customerTable" id='myTable'>
                    <thead class="table-light">
                        <tr class= 'text-center' >
                            <!-- <th scope="col" style="width: 50px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        value="option">
                                </div>
                            </th> -->
                            <th class="sort text-black px-2 m-0" data-sort="id">Id</th>
                            <th class="sort" data-sort="client_name">@lang('translation.name')</th>
                            <th  data-sort="contact">@lang('translation.contact')</th>
                            <th class=" px-3" data-sort="gender">@lang('translation.gender')</th>
                            <th class=" px-3 text-break" data-sort="cin">CIN</th>
                            <th class='address'>@lang('translation.address')</th>
                            <th data-sort="cases">@lang('translation.cases')</th>
                            <th >@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach($clients as $client)
                            <tr >
                                <!-- <th scope="row">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="chk_child"
                                            value="option1">
                                    </div>
                                </th> -->

                                <td class="id">000{{ $client->id }}</td>
                                
                                <td class="client_name">{{ $client->name }}</td>
                                <td class="contact">{{ $client->contact_info }}</td>
                                <td class="gender">@lang('translation.'. $client->gender)</td>
                                <td class="cin">{{ substr($client->CIN, 0, 10) }}</td>
                                <td class="address text-wrap">{{ $client->address }} </td>
                                <td class="cases"><span class="fs-5 badge text-primary text-uppercase">
                                    {{ count($client->cas) }}
                                </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                    
                                        <div class="edit">
                                            @component('clients.edit-client', ['clinet'=> $client])
                                            @endcomponent
                                        </div>
                                        <div class="view">
                                            <a href="{{ url('client/'.$client->id) }}">
                                                <button type='button' class='btn btn-sm btn-primary bg-primary'>
                                                    <i class='ri-eye-fill align-middle'></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="remove">
                                            <button type="button" id='{{ $client->id }}' class="btn btn-sm btn-soft-danger remove-list bg-danger-subtle" data-bs-toggle="modal" data-bs-target="#modal-{{$client->id}}" >
                                                <i class="text-danger ri-delete-bin-5-fill align-bottom"></i>
                                            </button>
                                            <div class="modal fade bs-example-modal-center" id="modal-{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-5">
                                                            <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json"
                                                                trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                                                            </lord-icon>
                                                            <div class="mt-4">
                                                                <h4 class="mb-3">@lang('translation.deleteMessage') @lang('translation.client')</h4>
                                                                <p class="text-muted mb-4 text-wrap">@lang('translation.deleteConfirmation')</p>
                                                                <form action="{{ url('/client/'.$client->id) }}" method='POST'  class="hstack gap-2 justify-content-center">
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
                            {{ $clients->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div><!-- end card -->
   
</div>




  

<!-- end table responsive -->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
    
<script>
    $('#addClient').on('submit', ()=> FormSubmition(event, 'POST', '/store-client'))
    $('#updateClient').on('submit', ()=> FormSubmition(event, 'PUT', `/client/${event.target.classList[0]}`))

</script>
    <!-- <script>
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const handelClient = (id)=>{
            console.log(id, parseInt(id))
            fetch('http://localhost:8000/client/'+parseInt(id),{
                method: "GET",
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
        }
    </script> -->
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>


    <!-- listjs init -->
    <script src="{{ URL::asset('build/js/pages/listjs.init.js') }}"></script>

    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/5fff77269d.js" crossorigin="anonymous"></script>
@endsection

