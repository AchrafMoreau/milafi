<div class="live-preview">
    
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">
        <i class="fa-solid fa-user-plus m-0 p-0 me-2"></i>
        @lang('translation.addCourt')
    </button>
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">@lang('translation.addCourt')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/store-court') }}" method='POST'>
                        @csrf
                        @method('POST')
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">@lang("translation.court")</label>
                                    <input type="text" name='name' class="form-control" id="name" placeholder="@lang('translation.enterCourtName')">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="contact_info" class="form-label">@lang("translation.location")</label>
                                <input type="text" class="form-control" name='location' id="location" placeholder="@lang('translation.enterLocation')">
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="category" class="form-label">@lang("translation.category")</label>
                                <select name="category" id="category" class="form-select mb-3 text-capitalize"  aria-label="Default select example">
                                    <option value="première instance">@lang("translation.premiereInstance")</option>
                                    <option value="appel">@lang("translation.appel")</option>
                                    <option value="Centres des juges résidents">@lang("translation.centerJudgeResi")</option>
                                    <option value="appel de commerce">@lang("translation.appelCommerce")</option>
                                    <option value="commerciaux">@lang("translation.commercial")</option>
                                    <option value="appel administratives">@lang("translation.appelAdmin")</option>
                                    <option value="administratifs">@lang("translation.administratif")</option>
                                    <option value="cassation">@lang("translation.cassation")</option>
                                </select>
                            </div><!--end col-->
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