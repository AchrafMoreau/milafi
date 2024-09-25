@extends('layouts.master')
@section('title') @lang('translation.form-select') @endsection
@section('content')
    @section('css')
        <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" /> <!-- 'classic' theme -->
        <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" /> <!-- 'monolith' theme -->
        <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" /> <!-- 'nano' theme -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection



    <div class="row mt-5">
        <div class="col-lg-12" id='case-form'>
            @csrf
            @method('POST')
            <div class="card ribbon-box" >
                @if($case->status == 'Open')
                    <div class="ribbon ribbon-success ribbon-shape">@lang("translation.Open")</div>
                @elseif($case->status == 'Closed')
                    <div class="ribbon ribbon-danger  ribbon-shape">@lang("translation.Closed")</div>
                @else
                    <div class="ribbon ribbon-primary  ribbon-shape">@lang("translation.Pending")</div>
                @endif
                <div  class="form-check d-flex justify-content-end w-auto mt-3 mx-3 form-switch form-switch-right form-switch-md"  style="float: left;">
                    <div >
                        <input value='{{ $case->serial_number }}'  class="w-auto form-control form-control-sm" type="text" name='serial_number' disabled placeholder="@lang('translation.reference')">
                    </div>
                </div>
                <div class="card-header align-items-center d-flex justify-content-end">
                    <div class="d-flex flex-column  flex-grow-1">
                        <h1 class=" mb-0 m-0 p-0 text-center">مكتب المحاماة</h1>
                        <h5 class=" mb-0 m-0 p-0 text-center">Cabinet Des Avocats</h5>
                    </div>
                </div><!-- end card header -->

                <div class="d-flex flex-column  flex-grow-1 mt-3">
                    <h1 class=" mb-0 m-0 p-0 text-center">الاستاذ {{ Auth::user()->name_in_arab }} محامي بهيئة {{ Auth::user()->city_in_arab }}</h1>
                    <h4 class=" mb-0 m-0 p-0 text-center capitalize">Matrie {{ Auth::user()->name }} Avocat au Bareau {{ Auth::user()->city }}</h4>
                </div>
                <div id='courtSelect' class="d-flex gap-5 px-4 py-3  border rounded-pill m-auto w-75  mt-3">
                        <h2 class='m-0 p-0'>
                            @lang('translation.court')  :
                            <span>{{ $case->court->name }}</span>
                        </h2>
                </div>
                <div class="card-body">
                    <div class="live-preview mt-3">
                        <div class="row gy-4">
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <div class="row d-flex justify-center-center align-items-end">
                                        <label for="choices-single-default" class="form-label ">@lang('translation.client') :</label>
                                        <select data-choices 
                                        id="choices-single-default" name='client'disabled class='form-control'>
                                            <option value="{{ $case->client->id }}">{{ $case->client->name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_type" class="form-label fs-6">@lang('translation.fileSubject') : </label>
                                    <input disabled name='title' type="text" class="form-control" id="case_type" value='{{ $case->title_file }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-6">
                                
                                <div class='d-flex flex-column '>
                                    <label for="clinet_contact" class="form-label fs-6">@lang('translation.phone') :</label>
                                    <input disabled type="text" name='phone' class="form-control disable" id="case_contact_info" disabled value='{{ $case->client->contact_info }}'>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_number" class="form-label fs-6">@lang('translation.fileNumber') :</label>
                                    <input type="text" disabled name='titleNumber' class="form-control" id="case_number" value='{{ $case->title_number }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="choices-single-default" class="form-label ">@lang('translation.client') :</label>
                                    <select data-choices 
                                    id="choices-single-default" disabled name='judge' class='form-control'>
                                        <option value="{{ $case->judge->id }}">{{ $case->judge->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="opponent" class="form-label fs-6">@lang('translation.opponent') : </label>
                                    <input disabled type="text" name='opponent' class="form-control" id="opponent" value='{{ $case->opponent }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_report" class="form-label fs-6">@lang('translation.fileReport') :</label>
                                    <input disabled type="text" name='fileReport' class="form-control" id="case_report" value='{{ $case->report_file }}'>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_exec" class="form-label fs-6">@lang('translation.fileExecution') : </label>
                                    <input disabled type="text" name='fileExecution' class="form-control" id="case_exec" value='{{ $case->execution_file }}'>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.fileNumber') :  </label>
                                    <input type="text" disabled name='reportNumber' class="form-control"  id="report_number" value="{{ $case->report_number }}">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.fileNumber') :</label>
                                    <input type="text" disabled name='executionNumber' class="form-control" id="report_number" value=" {{ $case->execution_number }}" >
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.status') :</label>
                                    <select disabled name='status'value="{{ $case->status }}"  class="form-select mb-3"  aria-label="Default select example">
                                        <option value="Open" {{ $case->status === 'Opend' ? 'selected' : ''}}>Opend</option>
                                        <option value="Closed"{{ $case->status === 'Closed' ? 'selected' : ''}}>Closed</option>
                                        <option value="Pending"{{ $case->status === 'Pending' ? 'selected' : ''}}>Pending</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Vertical alignment -->
    <div class="row">
        <div class="cardHead m-3">
            <h3>
                @lang('translation.procedure')
            </h3>
        </div>
        <div class="col-lg-12">
            <div class="card px-3 table-responsive mt-2">
                <table class="table align-middle">
                    <thead>
                        <th class='text-center'>@lang('translation.date')</th>
                        <th class='text-center'>@lang('translation.time')</th>
                        <th class='text-center'>@lang('translation.invoices')</th>
                        <th class='text-center'>@lang('translation.fees')</th>
                        <th>@lang('translation.procedure')</th>
                    </thead>
                    <tbody>
                        @foreach($case->procedure as $proc)
                            <tr>
                                <td class='px-3 text-nowrap text-center'>{{ $proc->date }}</td>
                                <td class='px-3 text-nowrap text-center'>{{ $proc->time }}</td>
                                <td class='text-nowrap text-center'>{{ number_format($proc->invoice, 2) }} {{ "   " }} @lang('translation.currency')</td>
                                <td class='text-nowrap text-center'>{{ number_format($proc->fee, 2) }} {{ "   " }} @lang('translation.currency')</td>
                                <td class='word-wrap'>{{ $proc->procedure }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="cardHead m-3">
                <h3>
                    @lang('translation.documents')
                </h3>
            </div>
        <div class="card col-lg-12">
            <div class="listjs-table col-lg-12" id="customerList">
                <div class="row g-4 mb-3">
                    <div class="col-sm-auto">
                        <div class="col-sm">
                            
                        </div>
                    </div>
                
                </div>

                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap" id="customerTable" id='myTable'>
                        <thead class="table-light">
                            <tr class= 'text-center' >
                                <th class="text-black px-2 m-0" >Id</th>
                                <th >@lang('translation.fileName')</th>
                                <th >@lang('translation.createAt')</th>
                                <th >@lang('translation.action')</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                                @foreach($case->document as $doc)
                            <tr>
                                <td class="id">000{{ $doc->id }}</td>
                                <td class="client_name text-center">{{ $doc->name }}</td>
                                <td class="address text-wrap text-center">{{ $doc->created_at->diffForHumans() }} </td>
                                <td class='d-flex justify-content-center'>  
                                    <div class="d-flex gap-2">
                                    
                                        <div class="view">
                                            <a href="{{ url('/show-doc/'.$doc->id) }}">
                                                <button type="button" class="btn btn-sm btn-primary">
                                                    <i class='ri-eye-fill align-middle'></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="download">
                                            <a href="{{ url('/uploadFile/'.$doc->file_path) }}">
                                                <button class="btn btn-success btn-sm" type='button'>
                                                    <i class='las la-download'></i>
                                                </button>
                                            </a>
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
            </div>
        </div>
    </div>       
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>                                       


    <!-- listjs init -->
    <!-- input flag init -->
    <script src="{{URL::asset('build/js/pages/flag-input.init.js')}}"></script>
    <script src="https://kit.fontawesome.com/5fff77269d.js" crossorigin="anonymous"></script>
@endsection