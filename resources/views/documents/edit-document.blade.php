

<div class="live-preview">
    <button type="button" class="btn btn-success btn-sm" 
        data-bs-toggle="modal"
        data-bs-target="#editeModel{{ $doc->id}}">
        <i class='ri-pencil-fill align-bottom'></i>
    </button>
    <div class="modal fade" id="editeModel{{ $doc->id}}" tabindex="-1" aria-labelledby="editeModel{{ $doc->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">@lang('translation.editDocument')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/document/'.$doc->id) }}" method='POST' enctype="multipart/form-data">
                        @method("PUT")
                        {{ csrf_field() }}
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">@lang("translation.fileName")</label>
                                    <input type="text" value='{{ $doc->name }}' name='name' class="form-control" id="name" placeholder="@lang('translation.enterFileName')">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="case" class="form-label">@lang("translation.case")</label>
                                <select  data-choices name="case" required
                                id="choices-single-default"  class='form-control ' >
                                    <option value="{{ $doc->cas->id }}" selected>{{ $doc->cas->title_file }}</option>
                                    @foreach($cases as $case)
                                        @if($case->id != $doc->cas->id)
                                            <option value="{{ $case->id }}">{{ $case->title_file }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="card-body" >
                                    <p class="text-muted text-wrap">@lang('translation.fileMessage').</p>
                                    <input type="file"  class="filepond filepond-input-multiple" id='docs' name="docs"
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

