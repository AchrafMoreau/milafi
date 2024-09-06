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

<div class="card">
    <div class="card-body w-50 border text-center my-4" style="border-style: dashed; border-color: #ddd; margin-block: 1rem; margin-inline:auto;">
        <h5 class="card-title mb-3">Info</h5>
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <th class='ps-0' scope='row'>@lang('translation.fullName') :</th>
                        <td class='text-muted'>{{ $client->name }}</th>
                    </tr>
                    
                    <tr>
                        <th class="ps-0" scope="row">@lang('translation.contact') :</th>
                        <td class="text-muted">{{ $client->contact_info }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0" scope="row">@lang('translation.gender') :</th>
                        <td class="text-muted">{{ $client->gender }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0" scope="row">@lang('translation.address') :</th>
                        <td class="text-muted">{{ $client->address }}
                        </td>
                    </tr>
                    <tr>
                        <th class="ps-0" scope="row">@lang('translation.CIN') :</th>
                        <td class="text-muted">{{ $client->CIN }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!-- end card body -->
</div>


<div class="card mb-5">
    <div class="card-body">
        <div class="listjs-table" id="customerList">
            <div class="table-responsive table-card mt-3 mb-1">
                @if(count($client->cas) === 0)
                    <div >
                        <div class="text-center">
                            
                            <h5 class="mt-2">Sorry! No Cases Was Found</h5>
                            <p class="text-muted mb-0">We've searched more than 150+ Case We did not find any
                                cases for you search.</p>
                        </div>
                    </div>
                @else
                <table class="table align-middle table-hover" id="customerTable">
                    <thead class="table-light">
                        <tr class= 'text-center' >
                            <th class="sort text-black px-2 m-0" data-sort="id">S.N</th>
                            <th  class="sort" data-sort="client_name">@lang('translation.caseTitle')</th>
                            <th class="sort" data-sort="client_name">@lang('translation.fileNumber')</th>
                            <th  class='sort' data-sort="contact">@lang('translation.client')</th>
                            <th class=" px-3" data-sort="gender">@lang('translation.court')</th>
                            <th class='address'>@lang('translation.judge')</th>
                            <th class="sort" data-sort="status">@lang('translation.status')</th>
                            <th >@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach($client->cas as $case)
                            <tr style='cursor: pointer;' onclick="handleCase(' {{ $case->id }} ')">
                                    
                                

                                <td class="id">{{ $case->serial_number }}</td>
                                <td class="client_name word-wrap">{{ $case->title_file }}</td>
                                <td class="contact">{{ $case->title_number }}</td>
                                <td class="gender">{{ $case->client['name'] }}</td>
                                <td class="address text-wrap">{{ $case->court['name'] }} </td>
                                <td class="cases">{{ $case->judge['name'] }}</td>
                                <td class="status"><span
                                    class="badge {{ $case->status == 'Open' ? 'bg-success-subtle text-success' : ($case->status == 'Closed' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary') }} text-uppercase" >{{ $case->status }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                    
                                        <a class="show" href="{{ url('cas/'.$case->id) }} ">
                                            <button type="button" id='{{ $case->id }}' class="btn btn-sm btn-primary remove-item-btn" >
                                                View Case
                                            </button>
                                        </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
                @endif
            
            </div>
        </div>
    </div>
</div>

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
@endsection