@extends('layouts.master')
@section('title') @lang('translation.form-select') @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Cases @endslot
        @slot('title') Add Case @endslot
    @endcomponent
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" /> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" /> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" /> <!-- 'nano' theme -->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #case{
            position: relative;
        }
        #case::after{
            position: absolute;
            content: attr(data-label);
            height: 150px;
            top: -14px;
            left: 30px;
            padding: 0.5rem;
            width: 2rem;
            background: #3949ab;
            color: white;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
        }
        #case::before{
            position: absolute;
            z-index: -1;
            top: -0.5rem;
            left: 3rem;
            content: '';
            background: #283593;
            height: 28px;
            width: 28px;
            transform: rotate(45deg);
        }

        #headerCard{
            position: relative;
        }
        #headerCard::before{
            position: absolute;
            top: 110px;
            left: 1rem;
            z-index: 1;
            content: '';
            background: #fff;
            height: 28px;
            width: 28px;
            transform: rotate(45deg);
        }
    </style>
    @if($case->status === 'Closed')
    <style>
        #case::after{
            background: #f7666e !important;
        }
        #case::before{
            background: red !important;
        }

    </style>
    @endif
    @if($case->status === 'Open')
    <style>
        #case::after{
            background: #3cd188 !important;
        }
        #case::before{
            background: green !important;
        }
    </style>
    @endif
    <div class="row">
        <form class="col-lg-12" action="{{ url('/case-update/'.$case->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="card" id='case' >
                <div id='headerCard' class="form-check w-auto mt-3 mx-3 form-switch form-switch-right form-switch-md">
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
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <div class="row d-flex justify-center-center align-items-end">
                                        <label for="choices-single-default" class="form-label ">@lang('translation.client') :</label>
                                        <select data-choices 
                                        id="choices-single-default" name='client' onchange="fillPhoneInput(event)" class='form-control'>
                                            <option value="{{ $case->client->id }}">{{ $case->client->name }}</option>
                                            @foreach($clients  as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_type" class="form-label fs-6">@lang('translation.fileSubject') : </label>
                                    <input name='title' type="text" class="form-control" id="case_type" value='{{ $case->title_file }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="clinet_contact" class="form-label fs-6">@lang('translation.phone') :</label>
                                    <input type="text" name='phone' class="form-control disable" id="case_contact_info" disabled value='{{ $case->client->contact_info }}'>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_number" class="form-label fs-6">@lang('translation.fileNumber') :</label>
                                    <input type="text" name='titleNumber' class="form-control" id="case_number" value='{{ $case->title_number }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
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
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="opponent" class="form-label fs-6">@lang('translation.opponent') : </label>
                                    <input type="text" name='opponent' class="form-control" id="opponent" value='{{ $case->opponent }}'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_report" class="form-label fs-6">@lang('translation.fileReport') :</label>
                                    <input type="text" name='fileReport' class="form-control" id="case_report" value='{{ $case->report_file }}'>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_exec" class="form-label fs-6">@lang('translation.fileExecution') : </label>
                                    <input type="text" name='fileExecution' class="form-control" id="case_exec" value='{{ $case->execution_file }}'>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.fileNumber') :  </label>
                                    <input type="text" name='reportNumber' class="form-control"  id="report_number" value="{{ $case->report_number }}">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.fileNumber') :</label>
                                    <input type="text" name='executionNumber' class="form-control" id="report_number" value=" {{ $case->execution_number }}" >
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
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
                        <div class="col-12 d-flex gap-3 flex-row-reverse">
                            <button class='w-auto btn-success btn ' id='submit' type='submit'>@lang('translation.edit')</button>
                            <a href="{{ url('/cas') }}">
                                <button class='w-auto btn-light btn ' type='button'>@lang('translation.cancel')</button>
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
                    <div class="col-lg-9">
                        <input type="text" class="form-control @error('date') is-invalid @enderror" 
                            name='date' value="{{ old('date') }}" placeholder="DD-MM-YYYY" id="cleave-date">
                        @error('date')
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
    <!-- Vertical alignment -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card px-3 table-responsive mt-2">
                <table class="table align-middle">
                    <thead>
                        <th>@lang('translation.date')</th>
                        <th>@lang('translation.invoices')</th>
                        <th>@lang('translation.fees')</th>
                        <th>@lang('translation.procedure')</th>
                    </thead>
                    <tbody>
                        @foreach($case->procedure as $proc)
                            <tr>
                                <td class='px-3 text-nowrap'>{{ $proc->date }}</td>
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
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>                                       
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>


    <!-- listjs init -->
    <script src="{{ URL::asset('build/js/pages/listjs.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/multi.js/multi.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/@tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-input-spin.init.js') }}"></script>
    <!-- input flag init -->
    <script src="{{URL::asset('build/js/pages/flag-input.init.js')}}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/5fff77269d.js" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('build/libs/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-masks.init.js') }}"></script>
@endsection