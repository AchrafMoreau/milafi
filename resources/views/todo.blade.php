@extends('layouts.master')
@section('title')
@lang('translation.to-do')
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/dragula/dragula.min.css') }}" rel="stylesheet" type="text/css" />
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content')

<div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
    <!--end side content-->
    <div class="file-manager-content w-100 p-4 pb-0">
        <div class="row mb-4">
            <div class="col-auto order-1 d-block d-lg-none">
                <button type="button" class="btn btn-soft-success btn-icon btn-sm fs-16 file-menu-btn">
                    <i class="ri-menu-2-fill align-bottom"></i>
                </button>
            </div>
            <div class="col-sm order-3 order-sm-2 mt-3 mt-sm-0">
                <h5 class="fw-semibold mb-0">@lang('translation.manageYourTime')</h5>
            </div>

            
        </div>
        <div class="p-3 bg-light rounded mb-4">
            <div class="row g-2">
                <div class="col-lg-auto">
                    <select class="form-control" data-choices data-choices-search-false name="choices-select-sortlist" id="choices-select-sortlist">
                        <option value="">@lang('translation.sort')</option>
                        <option value="By ID">@lang('translation.ById')</option>
                        <option value="By Name">@lang('translation.ByName')</option>
                    </select>
                </div>
                <div class="col-lg-auto">
                    <select class="form-control" data-choices data-choices-search-false name="choices-select-status" id="choices-select-status">
                        <option value="">@lang('translation.allTask')</option>
                        <option value="Completed">@lang('translation.Completed')</option>
                        <option value="Inprogress">@lang('translation.Inprogress')</option>
                        <option value="Pending">@lang('translation.Pending')</option>
                        <option value="New">@lang('translation.New')</option>
                    </select>
                </div>
                <div class="col-lg">
                    <div class="search-box">
                        <input type="text" id="searchTaskList" class="form-control search" placeholder="Search task name">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-lg-auto">
                    <button class="btn btn-primary createTask" type="button" data-bs-toggle="modal" data-bs-target="#createTask">
                        <i class="ri-add-fill align-bottom"></i>@lang('translation.addTask')
                    </button>
                </div>
            </div>
        </div>

        <div class="todo-content position-relative px-4 mx-n4" id="todo-content">
            <div id="elmLoader">
                <div class="spinner-border text-primary avatar-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="todo-task" id="todo-task">
                <div class="table-responsive">
                    <table class="table align-middle position-relative table-nowrap">
                        <thead class="table-active">
                            <tr>
                                <th scope="col">@lang('translation.title')</th>
                                <th scope="col">@lang('translation.description')</th>
                                <th scope="col">@lang('translation.dueDate')</th>
                                <th scope="col">@lang('translation.status')</th>
                                <th scope="col">@lang('translation.priority')</th>
                                <th scope="col">@lang('translation.action')</th>
                            </tr>
                        </thead>

                        <tbody id="task-list" >
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="py-4 mt-4 text-center" id="noresult" style="display: none;">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px"></lord-icon>
                <h5 class="mt-4">@lang('translation.NoResultWasFound')</h5>
            </div>
        </div>

    </div>
</div>

<!-- Start Create Project Modal -->
<!-- End Create Project Modal -->

<!-- Modal -->
<div class="modal fade" id="createTask" tabindex="-1" aria-labelledby="createTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-success-subtle">
                <h5 class="modal-title" id="createTaskLabel">@lang('translation.addTask')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="createTaskBtn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="task-error-msg" class="alert alert-danger py-2"></div>
                <form autocomplete="off" action="" id="creattask-form">
                    <input type="hidden" id="taskid-input" class="form-control">
                    <div class="mb-3">
                        <label for="task-title-input" class="form-label">@lang('translation.title')</label>
                        <input type="text" id="task-title-input" class="form-control" placeholder="@lang('translation.enterTitle')">
                    </div>
                    <div class="mb-3">
                        <label for="task-title-input" class="form-label">@lang('translation.description')</label>
                        <textarea type="text" id="task-description-input" class="form-control" rows='3' placeholder="@lang('translation.enterDesc')"></textarea>
                    </div>
                    <div class="row g-4 mb-3">
                        <div class="col-lg-6">
                            <label for="task-status" class="form-label">@lang('translation.status')</label>
                            <select class="form-control" data-choices data-choices-search-false id="task-status-input">
                                <option value="New" selected>@lang('translation.New')</option>
                                <option value="Inprogress">@lang('translation.Inprogress')</option>
                                <option value="Pending">@lang('translation.Pending')</option>
                                <option value="Completed">@lang('translation.Completed')</option>
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="priority-field" class="form-label">@lang('translation.priority')</label>
                            <select class="form-control" data-choices data-choices-search-false id="priority-field">
                                <option value="">@lang('translation.priority')</option>
                                <option value="High">@lang('translation.High')</option>
                                <option value="Medium">@lang('translation.Medium')</option>
                                <option value="Low">@lang('translation.Low')</option>
                            </select>
                        </div>
                        <!--end col-->
                    </div>
                    <div class="mb-4">
                        <label for="task-duedate-input" class="form-label">@lang('translation.dueDate'):</label>
                        <input type="date" id="task-duedate-input" class="form-control" placeholder="@lang('translation.dueDate')">
                    </div>

                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-ghost-success" data-bs-dismiss="modal"><i class="ri-close-fill align-bottom"></i> @lang('translation.close')</button>
                        <button type="submit" class="btn btn-primary" id="addNewTodo">@lang('translation.addTask')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end create taks-->

<!-- removeFileItemModal -->
<div id="removeTaskItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-removetodomodal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>@lang('translation.deleteMessage') @lang('translation.task')</h4>
                        <p class="text-muted mx-4 mb-0">@lang('translation.deleteConfirmation')</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-todoitem">@lang('translation.yesDoIt')</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--end delete modal -->

@endsection
@section('script')
<script>
    window.translations = {
        pending: "{{ __('translation.Pending') }}",
        inprogress: "{{ __('translation.Inprogress') }}",
        completed : "{{ __('translation.Completed') }}",
        new: "{{ __('translation.new') }}",
        low: "{{ __('translation.Low') }}",
        high: "{{ __('translation.High') }}",
        medium : "{{ __('translation.Medium') }}",
        createTask : "{{ __('translation.createTask') }}",
        editTask : "{{ __('translation.editTask') }}",
        save : "{{ __('translation.edit') }}",
        yes : "{{ __('translation.yesDoIt') }}",
    }

    console.log("hello")
</script>
<script src="{{URL::asset('build/libs/dragula/dragula.min.js')}}"></script>
<script src="{{URL::asset('build/libs/dom-autoscroller/dom-autoscroller.min.js')}}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="{{URL::asset('build/js/pages/todo.init.js')}}"></script>
@endsection
