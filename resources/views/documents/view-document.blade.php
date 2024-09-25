@extends('layouts.master')
@section('title') @lang('translation.form-select') @endsection
@section('content')

    

    <div class="row mt-5">
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
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection