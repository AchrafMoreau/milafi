@extends('layouts.master')
@section('title') @lang('translation.form-select') @endsection
@section('content')
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" /> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" /> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" /> <!-- 'nano' theme -->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .selectCourt{
            border: none !important;
            font-size: 1rem !important;
        }
        .selectCourt:hover{
            box-shadow: none !important;
            border: none !important;
            outline: none !important;
        }
        .selectCourt:focus{
            box-shadow: none !important;
            border: none !important;
            outline: none !important;
        }
    </style>
    <div class="row mt-5">
        <form class="col-lg-12" action="{{ url('/store-case') }}" method="POST">
            @csrf
            @method('POST')
            <div class="card" stye="background:#e37ba4;">
                <div class="form-check w-auto mt-3 mx-3 form-switch form-switch-right form-switch-md">
                    <div >
                        <input name='serial_number'  class="w-auto form-control form-control-sm" required type="text" placeholder="@lang('translation.reference')">
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
                    <select  data-choices name="court" required name='court'
                    id="choices-single-default"  class='form-control ' >
                        @foreach($courts  as $cour)
                            <option value="{{ $cour->id }}" class='color:#495057;'>{{ $cour->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body">
                    <div class="live-preview mt-3">
                        <div class="row gy-4">
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <div class="row d-flex justify-center-center align-items-end">
                                        <div class="col-7">
                                            <label for="selectClient" class="form-label ">@lang('translation.client') :</label>
                                            <select required data-choices name="client" onchange="fillPhoneInput(event)"
                                            id="selectClient" class='form-control clientSelect' onload="getClients()">
                                                <option value="">This is a placeholder</option>
                                                @foreach($clients  as $client)
                                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-5">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">
                                                <i class="fa-solid fa-user-plus m-0 p-0 me-2"></i>
                                                @lang('translation.addclient')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_type" class="form-label fs-6">@lang('translation.fileSubject') : </label>
                                    <input type="text" required value="{{ old('file_subject') }}" class="form-control" name='file_subject' id="case_type">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="clinet_contact" class="form-label fs-6">@lang('translation.phone') :</label>
                                    <div class="input-group" data-input-flag>
                                        <input type="text" class="form-control rounded-end flag-input" name='contact_info' value="" placeholder="Enter number" id='case_contact_info'  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                        <div class="dropdown-menu w-100">
                                            <div class="p-2 px-3 pt-1 searchlist-input">
                                                <input type="text" class="form-control form-control-sm border search-countryList"  placeholder="Search country name or country code..." />
                                            </div>
                                            <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                        </div>
                                        <button style='z-index:0;' class="btn btn-light border " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="ml-3 country-codeno">+ 212</span>
                                            <img src="{{URL::asset('build/images/flags/ma.svg')}}" alt="flag img" height="20" class="country-flagimg rounded">
                                        </button>
                                    </div>
                                    <!-- <input type="text" required id="case_contact_info" class="form-control disable" name='contact_info'> -->
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_number" class="form-label fs-6">@lang('translation.fileNumber') :</label>
                                    <input type="text" class="form-control" required id="case_number" name='title_number'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <div class="row d-flex justify-contact-between align-items-end">
                                        <div class="col-7">
                                            <label for="selectJudge" class="form-label ">@lang('translation.judge') :</label>
                                            <select data-choices  required 
                                            id="selectJudge" name='judge' class='form-control'>
                                                @foreach($judges  as $judge)
                                                    <option value="{{ $judge->id }}">{{ $judge->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-5">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addjudgeModal">
                                                <i class="fa-solid fa-user-plus m-0 p-0 me-2"></i>
                                                @lang('translation.addJudge')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-xxl-3 col-lg-6">
                                    <div class='d-flex flex-column '>
                                        <div class="row d-flex justify-center-center align-items-end">
                                            <div class="col-7">
                                                <label for="choices-single-default" class="form-label ">@lang('translation.client') :</label>
                                                <select required data-choices name="client" onchange="fillPhoneInput(event)"
                                                id="choices-single-default" class='form-control'>
                                                    <option value="">This is a placeholder</option>
                                                    @foreach($clients  as $client)
                                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-5">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#examplemodalgrid">
                                                    <i class="fa-solid fa-user-plus m-0 p-0 me-2"></i>
                                                    @lang('translation.addclient')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="opponent" class="form-label fs-6">@lang('translation.opponent') : </label>
                                    <input type="text" class="form-control" name='opponent' required id="opponent">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_report" class="form-label fs-6">@lang('translation.fileReport') :</label>
                                    <input type="text" class="form-control"  name='report_file' id="case_report">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_exec" class="form-label fs-6">@lang('translation.fileExecution') : </label>
                                    <input type="text" class="form-control"  id="case_exec" name='execution_file'>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.reportNumber') :  </label>
                                    <input type="text" class="form-control"  id="report_number" name='report_number'>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.executionNumber') :</label>
                                    <input type="text" class="form-control"  id="report_number" name='execution_number'>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>

                <div class="border-top px-5 pb-3 mt-4 pt-4"  >
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label for="cleave-date" class="form-label">@lang('translation.day')</label>
                        </div>
                        <div class="col-lg-3">
                            <!-- <input type="date" class="form-control"> -->
                            <input type="text" class="form-control @error('date') is-invalid @enderror" name='date'data-provider="flatpickr" id="dateInput" >
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
                            <textarea  rows="3" type="text" name='procedure' class="form-control @error('procedure') is-invalid @enderror" id="desc" placeholder='@lang("translation.enterProcedure")' ></textarea>
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
                                <input name='invoice' type='number' id='invoice' class="form-control"
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
                                <input name='fee' type='number' id='fee' class="form-control"
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
            <!-- <button class='btn-primary btn m-5 float-end' type='submit' id='case-form'>Submit</button> -->
        </form>

    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">@lang('translation.addclient')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addClient" >
                        <div class="row g-3">
                            <div class="col-xxl-12">
                                <div>
                                    <label for="name" class="form-label">@lang('translation.fullName')</label>
                                    <input type="text" required name='name' value='{{ old("name") }}' class="form-control" id="name" placeholder="@lang('translation.enterFullName')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label class="form-label">@lang('translation.gender')</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"  type="radio" name="gender" id="gender" value="male" required>
                                        <label value="{{ old('gender') }}" class="form-check-label " for="inlineRadio1">@lang('translation.male')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender" value="female" required>
                                        <label value="{{ old('gender') }}" class="form-check-label " for="inlineRadio2">@lang('translation.female')</label>
                                    </div>
                                </div>
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="CIN" class="form-label">@lang('translation.CIN')</label>
                                <input type="text" value="{{ old('CIN') }}" required class="form-control " name='CIN' id="CIN" placeholder="@lang('translation.enterCIN')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="contact" class="form-label">@lang('translation.contact')</label>
                                <input type="text" value="{{ old('contact') }}" required class="form-control "  name='contact_info' id="contact_info" placeholder="@lang('translation.enterContact')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-12">
                                <label for="address" class="form-label">@lang('translation.address')</label>
                                <input type="text" value="{{ old('address') }}" class="form-control " id="address" name='address' placeholder="@lang('translation.enterAddress')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                                    <button type="submit" id='submit' class="btn btn-primary">@lang('translation.submit')</button>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addjudgeModal" tabindex="-1" aria-labelledby="addjudgeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addjudgeModal">@lang('translation.addJudge')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id='addJudge' >
                        <div class="row g-3">
                            <div class="col-xxl-12">
                                <div>
                                    <label for="name" class="form-label">@lang("translation.fullName")</label>
                                    <input type="text" name='name' class="form-control" id="name" placeholder="@lang('translation.enterFullName')">
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label class="form-label">@lang("translation.gender")</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"  type="radio" name="gender" id="inlineRadio1" value="male">
                                        <label class="form-check-label" for="inlineRadio1">@lang("translation.male")</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                                        <label class="form-check-label" for="inlineRadio2">@lang("translation.female")</label>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-12">
                                <label for="contact_info" class="form-label">@lang("translation.contact")</label>
                                <input type="texth" class="form-control" name='contact_info' id="contact_info" placeholder="@lang('translation.enterContact')">
                            </div><!--end col-->
                            <div class="col-xxl-12">
                                <label for="choices-single-default" class="form-label m-0 p-0">
                                        @lang('translation.court')
                                </label>
                                <select  data-choices name="court" 
                                id="choices-single-default"  class='form-control ' >
                                    <option value="" selected>..............</option>
                                    @foreach($courts  as $court)
                                        <option value="{{ $court->id }}" >{{ $court->name }}</option>
                                    @endforeach
                                </select>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                                    <button type="submit" id='submit' class="btn btn-primary">@lang('translation.submit')</button>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




    </div>

@endsection
@section('script')
    <script>

        
        
        const clientSelectElement = document.querySelector('#selectClient');
        const clientSelect = new Choices(clientSelectElement, {
            searchEnabled: true,
            itemSelectText: '',
        });
       
        const judgeSelectElement = document.querySelector('#selectJudge');
        const judgeSelect = new Choices(judgeSelectElement, {
            searchEnabled: true,
            itemSelectText: '',
        });

        $('#addClient').on('submit', ()=> FormSubmition(event, 'POST', '/store-client'))
        $('#addJudge').on('submit', ()=> FormSubmitionJudge(event, 'POST', '/store-judge'))


        const fillPhoneInput = (event, phoneNumber=null)=>{
            console.log(phoneNumber, event)
            const id = event?.target?.value
            const client = @json($clients);
            if(id) {
                const phone = client.filter((elm) => elm.id == id)[0].contact_info
                const phoneInput =  document.getElementById('case_contact_info');
                phoneInput.value = phone;
            }else{
                const phoneInput =  document.getElementById('case_contact_info');
                phoneInput.value = phoneNumber;
            }
        }
    </script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>                                       
    <script src="https://kit.fontawesome.com/5fff77269d.js" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('build/libs/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-masks.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/multi.js/multi.min.js') }}"></script>
    <script src="{{URL::asset('build/js/pages/flag-input.init.js')}}"></script>
@endsection