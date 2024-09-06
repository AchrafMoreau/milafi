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
    <div class="row">
        <form class="col-lg-12" action="{{ url('/store-case') }}" method="POST">
            @csrf
            @method('POST')
            <div class="card" stye="background:#e37ba4;">
                <div class="form-check w-auto mt-3 mx-3 form-switch form-switch-right form-switch-md">
                    <div >
                        <input name='serial_number' class="w-auto form-control form-control-sm" required type="text" placeholder="@lang('translation.reference')">
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
                            <div class="col-xxl-3 col-lg-6">
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
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">
                                                <i class="fa-solid fa-user-plus m-0 p-0 me-2"></i>
                                                @lang('translation.addclient')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_type" class="form-label fs-6">@lang('translation.fileSubject') : </label>
                                    <input type="text" required class="form-control" name='file_subject' id="case_type">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="clinet_contact" class="form-label fs-6">@lang('translation.phone') :</label>
                                    <input type="text" required id="case_contact_info" class="form-control disable" name='contact_info'>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_number" class="form-label fs-6">@lang('translation.fileNumber') :</label>
                                    <input type="text" class="form-control" required id="case_number" name='title_number'>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <div class='d-flex flex-column '>
                                        <label for="choices-single-default" class="form-label ">@lang('translation.judge') :</label>
                                        <select data-choices  required 
                                        id="choices-single-default" name='judge' class='form-control'>
                                            @foreach($judges  as $judge)
                                                <option value="{{ $judge->id }}">{{ $judge->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="opponent" class="form-label fs-6">@lang('translation.opponent') : </label>
                                    <input type="text" class="form-control" name='opponent' required id="opponent">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_report" class="form-label fs-6">@lang('translation.fileReport') :</label>
                                    <input type="text" class="form-control" required name='report_file' id="case_report">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="case_exec" class="form-label fs-6">@lang('translation.fileExecution') : </label>
                                    <input type="text" class="form-control" required id="case_exec" name='execution_file'>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.reportNumber') :  </label>
                                    <input type="text" class="form-control" required id="report_number" name='report_number'>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-lg-6">
                                <div class='d-flex flex-column '>
                                    <label for="report_number" class="form-label fs-6">@lang('translation.executionNumber') :</label>
                                    <input type="text" class="form-control" required id="report_number" name='execution_number'>
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
                            <label for="cleave-date" class="form-label">@lang('translation.date')</label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control @error('date') is-invalid @enderror" name='date' placeholder="DD-MM-YYYY" id="cleave-date">
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
                            <textarea  rows="3" type="text" name='procedure' class="form-control @error('procedure') is-invalid @enderror" id="desc" placeholder='desc about what u did' ></textarea>
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
                    <form id="addClient" method='POST'>
                        @csrf
                        @method('POST')
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">@lang('translation.fullName')</label>
                                    <input type="text" required name='name' value='{{ old("name") }}' class="form-control  " id="name" placeholder="Enter firstname">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label class="form-label">@lang('translation.gender')</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"  type="radio" name="gender" id="inlineRadio1" value="male">
                                        <label value="{{ old('gender') }}" class="form-check-label " for="inlineRadio1">@lang('translation.male')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                                        <label value="{{ old('gender') }}" class="form-check-label " for="inlineRadio2">@lang('translation.female')</label>
                                    </div>
                                </div>
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="CIN" class="form-label">CIN</label>
                                <input type="text" value="{{ old('CIN') }}" required class="form-control " name='CIN' id="contact_info" placeholder="Enter CIN">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="contact" class="form-label">@lang('translation.contact')</label>
                                <input type="text" value="{{ old('contact') }}" required class="form-control "  name='contact' id="contact" placeholder="Enter Contact">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="address" class="form-label">@lang('translation.address')</label>
                                <input type="text" value="{{ old('address') }}" class="form-control " id="address" name='address' placeholder="Enter Address">
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

    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/5fff77269d.js" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('build/libs/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-masks.init.js') }}"></script>
@endsection