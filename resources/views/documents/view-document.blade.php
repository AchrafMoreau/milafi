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
    <link href="/resources/css/app.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    

    <div class="row">
        <div class="card">
            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <th class='ps-0' scope='row'>@lang('translation.fileName') :</th>
                        <td class='text-muted'>{{ $doc->name }}</th>
                    </tr>
                    
                    <tr>
                        <th class="ps-0" scope="row">@lang('translation.case') :</th>
                        <td class="text-muted">
                            <a href="{{ url('/cas/'.$doc->cas->id) }}">
                                {{ $doc->cas->title_file }}
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <iframe src="{{ asset('storage/uploads/' . $doc->file_path) }}" width="100%" height="600px">
            Your browser does not support iframes.
        </iframe>
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