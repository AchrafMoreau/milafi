@extends('layouts.master')
@section('title') @lang('translation.form-select') @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.cases') @endslot
        @slot('title') @lang('translation.addcase') @endslot
    @endcomponent
    <link rel="stylesheet" href="{{ URL::asset('build/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" /> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" /> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" /> <!-- 'nano' theme -->

    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <div class="row">
        <form class="col-lg-12" action="{{ url('/case-update/'.$case->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="card ribbon-box">
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
                <div id='courtSelect' class="d-flex gap-5 px-4  border rounded-pill m-auto w-75  mt-3">
                    <label for="choices-single-default" class="d-flex align-items-center justify-content-center form-label m-0 p-0">
                        <h2 class='m-0 p-0'>
                            @lang('translation.court')
                        </h2>
                    </label>
                    <select  data-choices name="court" 
                    id="choices-single-default"  class='form-control ' >
                        <option value="{{ $case->court->id }}" style='color:#495057;'>{{ $case->court->name }}</option>
                        @foreach($court  as $cour)
                            <option value="{{ $cour->id }}" class='color:#495057;'>{{ $cour->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body">
                    <div class="live-preview mt-3">
                        <div class="row gy-4">
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <div class="row d-flex justify-center-center align-items-end">
                                        <label for="choices-single-default" class="form-label ">@lang('translation.client') :</label>
                                        <select data-choices id="choices-single-default" name='client' onchange="fillPhoneInput(event)" class='form-control'>
                                            <option value="{{ $case->client->id }}">{{ $case->client->name }}</option>
                                            @foreach($clients  as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_type" class="form-label fs-6">@lang('translation.fileSubject') : </label>
                                    <input name='title' type="text" class="form-control" id="case_type" value='{{ $case->title_file }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="clinet_contact" class="form-label fs-6">@lang('translation.phone') :</label>
                                    <div class="input-group" data-input-flag>
                                        <input type="text" class="form-control rounded-end flag-input" name='contact_info' value="{{ $case->client->contact_info }}" placeholder="Enter number" id='case_contact_info'  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                        <!-- <div class="dropdown-menu w-100">
                                            <div class="p-2 px-3 pt-1 searchlist-input">
                                                <input type="text" class="form-control form-control-sm border search-countryList"  placeholder="Search country name or country code..." />
                                            </div>
                                            <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                        </div> -->
                                        <button style='z-index:0;' class="btn btn-light border " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="ml-3 country-codeno">+ 212</span>
                                            <img src="{{URL::asset('build/images/flags/ma.svg')}}" alt="flag img" height="20" class="country-flagimg rounded">
                                        </button>
                                    </div>
                                    <!-- <input type="text" name='phone' class="form-control disable" id="case_contact_info" value='{{ $case->client->contact_info }}'> -->
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_number" class="form-label fs-6">@lang('translation.fileNumber') :</label>
                                    <input type="text" name='titleNumber' class="form-control" id="case_number" value='{{ $case->title_number }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="choices-single-default" class="form-label ">@lang('translation.client') :</label>
                                    <select data-choices 
                                    id="choices-single-default" name='judge' class='form-control'>
                                        <option value="{{ $case->judge->id }}">{{ $case->judge->name }}</option>
                                        @foreach($judges  as $judge)
                                            <option value="{{ $judge->id }}">{{ $judge->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="opponent" class="form-label fs-6">@lang('translation.opponent') : </label>
                                    <input type="text" name='opponent' class="form-control" id="opponent" value='{{ $case->opponent }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_report" class="form-label fs-6">@lang('translation.fileReport') :</label>
                                    <input type="text" name='fileReport' class="form-control" id="case_report" value='{{ $case->report_file }}'>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_exec" class="form-label fs-6">@lang('translation.fileExecution') : </label>
                                    <input type="text" name='fileExecution' class="form-control" id="case_exec" value='{{ $case->execution_file }}'>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.fileNumber') :  </label>
                                    <input type="text" name='reportNumber' class="form-control"  id="report_number" value="{{ $case->report_number }}">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.fileNumber') :</label>
                                    <input type="text" name='executionNumber' class="form-control" id="report_number" value=" {{ $case->execution_number }}" >
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.status') :</label>
                                    <select name='status'value="{{ $case->status }}"  class="form-select mb-3"  aria-label="Default select example">
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
                <div class="card-footer border-bottom">
                    <div class="row">
                        <div class="col-12 d-flex gap-3">
                            <button class='w-auto btn-success btn btn-lg' id='case-form' type='submit'>@lang('translation.submit')</button>
                            <a href="{{ url('/cas') }}">
                                <button class='w-auto btn-light btn btn-lg ' type='button'>@lang('translation.cancel')</button>
                            </a>
                        </div>
                    </div>
                </div> 

            </div>
        </form>

 
        <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalgridLabel">Add Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/store-client') }}" method='POST'>
                            @csrf
                            @method('POST')
                            <div class="row g-3">
                                <div class="col-xxl-6">
                                    <div>
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" name='name' class="form-control" id="name" placeholder="Enter firstname">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <label class="form-label">Gender</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"  type="radio" name="gender" id="inlineRadio1" value="male">
                                            <label class="form-check-label" for="inlineRadio1">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                                            <label class="form-check-label" for="inlineRadio2">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="other">
                                            <label class="form-check-label" for="inlineRadio3">Others</label>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-xxl-6">
                                    <label for="contact_info" class="form-label">Contact</label>
                                    <input type="texth" class="form-control" name='contact_info' id="contact_info" placeholder="Enter Contact">
                                </div><!--end col-->
                                <div class="col-xxl-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="texth" class="form-control" id="address" name='address' placeholder="Enter Address">
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <form class="col-lg-12"  action="{{ url('/procedude-add/'.$case->id) }}" method="POST">
            @csrf
            @method("POST")
            <div class="card px-5 py-3"  >
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="cleave-date" class="form-label">@lang('translation.date')</label>
                    </div>
                    <div class="col-lg-3">
                        <input type="text"  value="{{ old('date') }}"  class="form-control @error('date') is-invalid @enderror" name='date'data-provider="flatpickr" id="dateInput" >
                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="cleave-date" class="form-label">@lang('translation.time')</label>
                    </div>
                    <div class="col-lg-3">
                        <!-- <input type="date" class="form-control"> -->
                        <input type="time" class="form-control @error('time') is-invalid @enderror" name='time' data-provider="timepickr" data-time-basic="true" id="timeInput">
                        <span class='text-sm text-muted text-nowrap'>@lang('translation.PMtotheAm')</span>
                        <!-- <input type="text" class="form-control data-provider="flatpickr" id="dateInput" > -->
                            @error('time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="desc" class="form-label">@lang('translation.procedure')</label>
                    </div>
                    <div class="col-lg-9">
                        <textarea  rows="3" value="{{ old('procedure') }}" type="text" name='procedure' class="form-control @error('procedure') is-invalid @enderror" id="desc" placeholder= "@lang('translation.enterProc')" ></textarea>
                        @error('procedure')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="amount" class="form-label">@lang('translation.invoices')</label>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text">00.</span>
                            <input name='invoice' value="{{ old('invoice') }}" type='number' id='invoice' class="form-control"
                                aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text @error('invoice') is-invalid @enderror">MAD</span>
                        </div>
                        @error('invoice')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="fees" class="form-label">@lang('translation.fees')</label>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text">00.</span>
                            <input name='fee' type='number' id='fee' value="{{ old('fee') }}" class="form-control"
                                aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text @error('fee') is-invalid @enderror">MAD</span>
                        </div>
                        @error('fee')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 float-left">
                        <button class='btn btn-primary' id='p-form' type='submit'>@lang("translation.addProcedure")</button>
                    </div>
                </div>
            </div>
    
        </form>
    </div>



    <!--  ///////////////// PROCEDURES TABLE   /////////////////////// -->
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
                        <th>@lang('translation.date')</th>
                        <th>@lang('translation.time')</th>
                        <th>@lang('translation.invoices')</th>
                        <th>@lang('translation.fees')</th>
                        <th>@lang('translation.procedure')</th>
                    </thead>
                    <tbody>
                        @foreach($case->procedure as $proc)
                            <tr>
                                <td class='px-3 text-nowrap'>{{ $proc->date }}</td>
                                <td class='px-3 text-nowrap'>{{ $proc->time }}</td>
                                <td class='text-nowrap'>{{ number_format($proc->invoice, 2) }} {{ "   " }} @lang('translation.currency')</td>
                                <td class='text-nowrap'>{{ number_format($proc->fee, 2) }} {{ "   " }} @lang('translation.currency')</td>
                                <td class='word-wrap'>{{ $proc->procedure }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!--  ///////////////// DOCUMENTS TABLE   /////////////////////// -->
    <div class="row">
        <div class="row">
        <div class="cardHead  m-3">
            <h3>
                @lang('translation.documents')
            </h3>
        </div>
        <div class="col-sm justify-content-end d-flex">
            <div class="d-flex">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ducmentModal">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    @lang('translation.addDocument')
                </button>
            </div>
        </div>

        </div>
    <div class="card col-lg-12 my-3">
        <div class="listjs-table my-3" id="customerList">
            <div class="row g-4 mb-3">
            </div>

            <div class="table-responsive table-card mt-3 mb-1">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            
                            <th class="text-black px-5 m-0" data-sort="id">Id</th>
                            <th class="text-center" data-sort="client_name">@lang('translation.fileName')</th>
                            <th class='text-center'>@lang('translation.createAt')</th>
                            <th class='text-center'>@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($case->document as $doc)
                        <tr>
                            <td class="id px-5">000{{ $doc->id }}</td>
                            <td class="client_name text-center">{{ $doc->name }}</td>
                            <td class="address text-center text-wrap ">{{ $doc->created_at->diffForHumans() }} </td>
                            <td class='text-center'>
                                <div class="d-flex gap-2 justify-content-center">
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
            </div>

        </div>
    </div>
    <div class="modal fade" id="ducmentModal" tabindex="-1" aria-labelledby="ducmentModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ducmentModalLabel">@lang('translation.addDocument')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/store-doc') }}" method='POST' enctype="multipart/form-data" >
                        @csrf
                        @method('POST')
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">@lang("translation.fileName")</label>
                                    <input type="text" name='name' class="form-control" id="name" placeholder="@lang('translation.enterFileName')">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="case" class="form-label">@lang("translation.case")</label>
                                <select data-choices name="case" required
                                id="choices-single-default-cases"  class='form-control ' >
                                    <option value="{{ $case->id }}">{{ $case->title_file }}</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <div class="card-body" >
                                    <p class="text-muted">@lang("translation.fileMessage").</p>
                                    <input type="file" class="filepond filepond-input-multiple" id='docs' name="docs"
                                        data-allow-reorder="true" data-max-files="3">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                                    <button type="submit" class="btn btn-primary">@lang('translation.submit')</button>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('script')
    <script>
        const fillPhoneInput = (event)=>{
            const id = event.target.value
            const client = @json($clients);
            const phone = client.filter((elm) => elm.id == id)[0].contact_info
            const phoneInput =  document.getElementById('case_contact_info');
            phoneInput.value = phone;
        }
    </script>

    <script src="{{ URL::asset('build/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-file-upload.init.js') }}"></script>
    <!-- listjs init -->
    <script src="https://kit.fontawesome.com/5fff77269d.js" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>                                       

@endsection