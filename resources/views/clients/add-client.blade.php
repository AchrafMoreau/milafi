<div class="live-preview" >
    
    <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"> -->

    <button type="button" class="btn btn-primary" id='modal' data-bs-toggle="modal" data-bs-target="#exampleModalgrid">
        <i class="fa-solid fa-user-plus m-0 p-0 me-2"></i>
        @lang('translation.addclient')
    </button>
    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
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
                                    <input type="text" required name='name' value='{{ old("name") }}' class="form-control  " id="name" placeholder="@lang('translation.enterFullName')">
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
                                <label for="CIN" class="form-label">@lang('translation.CIN')</label>
                                <input type="text" value="{{ old('CIN') }}" required class="form-control " name='CIN' id="CIN" placeholder="@lang('translation.enterCIN')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="contact_info" class="form-label">@lang('translation.contact')</label>
                                <input type="text" value="{{ old('contact') }}" required class="form-control "  name='contact_info' id="contact_info" placeholder="@lang('translation.enterContact')">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
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
</div>


