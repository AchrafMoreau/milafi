@extends('layouts.master')
@section('title')
    @lang('translation.calendar')
@endsection
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Apps
        @endslot
        @slot('title')
            Calendar
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <button class="btn btn-primary w-100" id="btn-new-event">
                                <i class="mdi mdi-plus"></i> 
                                    @lang('translation.createNewEvent')
                            </button>

                            <div id="external-events">
                                <br>
                                <p class="text-muted">@lang('translation.eventMessage')</p>
                                <div class="external-event fc-event bg-success-subtle text-success"
                                    data-class="bg-success-subtle">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>
                                    @lang('translation.notImportant')
                                </div>
                                <div class="external-event fc-event bg-info-subtle text-info" data-class="bg-info-subtle">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>
                                    @lang('translation.meeting')
                                </div>
                                <div class="external-event fc-event bg-warning-subtle text-warning"
                                    data-class="bg-warning-subtle">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>
                                    @lang('translation.session')
                                </div>
                                <div class="external-event fc-event bg-danger-subtle text-danger"
                                    data-class="bg-danger-subtle">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>
                                    @lang('translation.veryImportant')
                                </div>
                            </div>

                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1">@lang('translation.upcomingEvents')</h5>
                        <p class="text-muted">@lang('translation.dontmissscheduledevents')</p>
                        <div class="pe-2 me-n1 mb-3" data-simplebar style="height: 400px">
                            <div id="upcoming-event-list"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body bg-info-subtle">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i data-feather="calendar" class="text-info icon-dual-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-15">@lang('translation.welcometoyourCalendar')</h6>
                                    <p class="text-muted mb-0">@lang('translation.welcomeMessageCalendar').</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div> <!-- end col-->

                <div class="col-xl-9">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div>
            <!--end row-->

            <div style='clear:both'></div>

            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-info-subtle">
                            <h5 class="modal-title" id="modal-title">@lang('translation.event')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                <div class="text-end">
                                    <a href="#" class="btn btn-sm btn-soft-primary" id="edit-event-btn"
                                        data-id="edit-event" onclick="editEvent(this)" role="button">@lang('translation.edit')</a>
                                </div>
                                <div class="event-details">
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1 d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="ri-calendar-event-line text-muted fs-16"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="d-block fw-semibold mb-0" id="event-start-date-tag"></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-time-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="d-block fw-semibold mb-0"><span id="event-timepicker1-tag"></span> -
                                                <span id="event-timepicker2-tag"></span></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-map-pin-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="d-block fw-semibold mb-0"> <span id="event-location-tag"></span></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-discuss-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="d-block text-muted mb-0" id="event-description-tag"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row event-form">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang("translation.type")</label>
                                            <select class="form-select d-none" name="category" id="event-category" required>
                                                <option value="bg-danger-subtle">@lang('translation.veryImportant')</option>
                                                <option value="bg-success-subtle">@lang('translation.notImportant')</option>
                                                <option value="bg-warning-subtle">@lang('translation.session')</option>
                                                <option value="bg-info-subtle">@lang('translation.meeting')</option>
                                            </select>
                                            <div class="invalid-feedback">@lang('translation.pleaseSelectAvalidEventCategory')</div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('translation.eventName')</label>
                                            <input class="form-control d-none" placeholder="@lang('translation.enterEventName')"
                                                type="text" name="title" id="event-title" required
                                                value="" />
                                            <div class="invalid-feedback">@lang('translation.pleaseSelectAvalidEventEventName')</div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label>@lang('translation.eventDay')</label>
                                            <div class="input-group d-none">
                                                <input type="text" id="event-start-date" name='event-day'
                                                    class="form-control flatpickr flatpickr-input"
                                                    placeholder="@lang('translation.selectDay')" readonly required>
                                                <span class="input-group-text"><i
                                                        class="ri-calendar-event-line"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-12" id="event-time">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">@lang('translation.startTime')</label>
                                                    <div class="input-group d-none">
                                                        <input id="timepicker1" type="text" name='start-time'
                                                            class="form-control flatpickr flatpickr-input"
                                                            placeholder="@lang('translation.selectStartTime')" readonly>
                                                        <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">@lang('translation.endTime')</label>
                                                    <div class="input-group d-none">
                                                        <input id="timepicker2" name='end-time' type="text"
                                                            class="form-control flatpickr flatpickr-input"
                                                            placeholder="@lang('translation.selectEndTime')" readonly>
                                                        <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="event-location">@lang('translation.location')</label>
                                            <div>
                                                <input type="text" class="form-control d-none" name="event-location"
                                                    id="event-location" placeholder="@lang('translation.enterLocation')">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <input type="hidden" id="eventid" name="eventid" value="" />
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('translation.description')</label>
                                            <textarea class="form-control d-none" id="event-description" name='desc' placeholder="@lang('translation.enterDescription')" rows="3"
                                                spellcheck="false"></textarea>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-soft-danger" id="btn-delete-event"><i
                                            class="ri-close-line align-bottom"></i> @lang('translation.delete')</button>
                                    <button type="submit" class="btn btn-success" id="btn-save-event">@lang('translation.addEvent')</button>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div> <!-- end modal-->
            <!-- end modal-->
        </div>
    </div> <!-- end row-->
@endsection
@section('script')

    <script src="{{ URL::asset('build/libs/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/calendar.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection