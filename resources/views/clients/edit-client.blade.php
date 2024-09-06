<div class="live-preview">
    <button class="btn btn-sm btn-success remove-item-btn" 
        data-bs-toggle="modal"
        data-bs-target="#editeModel{{ $clinet->id}}">
        <i class="ri-pencil-fill align-bottom"></i>
    </button>
    <div class="modal fade if(fade) @errors->all()->clear() endif" id="editeModel{{ $clinet->id}}" tabindex="-1" aria-labelledby="editeModel{{ $clinet->id}}label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">@lang('translation.editclient')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/client/'.$clinet->id) }}" id='updateClient' class='{{ $clinet->id }}' method='POST'>
                        @method("PUT")
                        {{ csrf_field() }}
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">@lang('translation.fullName')</label>
                                    <input type="text" name='name' class="form-control " id="name" value="{{$clinet->name}}" placeholder="Enter firstname">
                                        <span class="invalid-feedback" role="alert">
                                        </span>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label class="form-label ">@lang('translation.gender')</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"  {{ $clinet->gender == "male" ? 'checked' : "" }} type="radio" name="gender" id="inlineRadio1" value="male">
                                        <label class="form-check-label"  for="inlineRadio1">@lang('translation.male')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" {{ $clinet->gender == "female" ? 'checked' : "" }} type="radio" name="gender" id="inlineRadio2" value="female">
                                        <label class="form-check-label" for="inlineRadio2">@lang('translation.female')</label>
                                    </div>
                                </div>
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div>
                            <div class="col-xxl-6">
                                <label for="CIN" class="form-label">CIN</label>
                                <input type="text" class="form-control " name='CIN' id="CIN" value='{{$clinet->CIN}}' placeholder="Enter Contact">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="contact" class="form-label">@lang('translation.contact')</label>
                                <input type="text" class="form-control " name='contact' id="contact" value='{{$clinet->contact_info}}' placeholder="Enter Contact">
                                    <span class="invalid-feedback" role="alert">
                                    </span>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="address" class="form-label">@lang('translation.address')</label>
                                <input type="text" class="form-control " id="address" name='address' value='{{$clinet->address}}' placeholder="Enter Address">
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


