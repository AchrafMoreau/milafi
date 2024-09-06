@extends('layouts.master')
@section('title')
    @lang('translation.contacts')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            CRM
        @endslot
        @slot('title')
            Contacts
        @endslot
    @endcomponent
    <div class="col-xxl-3">
        <div class="card" id="contact-view-detail">
            <div class="card-body text-center">
                <div class="position-relative d-inline-block">
                    @php
                        $name = $contact->name;
                        $words = explode(' ', $name);
                        if(count($words) >= 2){
                            $initials = substr($words[0], 0, 1) . substr($words[1], 0, 1);
                        }else{
                            $initials = substr($name, 0, 1);
                        }
                    @endphp
                    <span class="contact-active position-absolute rounded-circle " data-letters="{{ $initials }}"></span>
                </div>
                <h5 class="mt-5 mb-1">{{ $contact->name }}</h5>
            </div>
            <div class="card-body w-50 border text-center my-4" style="border-style: dashed; border-color: #ddd; margin-block: 1rem; margin-inline:auto;">
                <h4 class="text-muted text-uppercase fw-semibold mb-5">@lang('translation.personalInformation')</h4>
                <div class="table-responsive table-card">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-medium" scope="row">@lang('translation.email')</td>
                                <td>{{ $contact->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium" scope="row">@lang('translation.phone')</td>
                                <td>{{ $contact->phone }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium" scope="row">@lang('translation.address')</td>
                                <td>{{ $contact->address }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium" scope="row">@lang('translation.tags')</td>
                                <td>
                                @foreach( json_decode($contact->tag) as $tag)
                                    <span class="badge bg-primary-subtle text-primary">@lang('translation.' .$tag)</span>
                                @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
@endsection