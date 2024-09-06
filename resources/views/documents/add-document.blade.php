
<div class="live-preview">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">
        <i class="fa-solid fa-file-circle-plus"></i>
        @lang('translation.addDocument')
    </button>
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">@lang('translation.addDocument')</h5>
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
                                <select  data-choices name="case" required
                                id="choices-single-default-cases"  class='form-control ' >
                                    @foreach($cases as $case)
                                        <option value="{{ $case->id }}">{{ $case->title_file }}</option>
                                    @endforeach
                                </select>
                            </div><!--end col-->
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

